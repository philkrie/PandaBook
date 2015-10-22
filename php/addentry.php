

<?php
include 'utils.php';

// ==========================================================================
// * addentry.php
// *
// * Author: M.Ishii
// * Date:   2015-10-10
// * Modified: 2015-10-19
// *
// * Desc.:   Adds a new entry to the specified address book (no duplicates).
// *
// * Inputs:  [POST] 'bookName' (String), 'fn' (String), 'ln' (String),
// *                 'addr1' (String), 'addr2' (String), 'city' (String),
// *                 'st' (String), 'zip' (String),
// *                 'ph' (String), 'email (String)
// *
// * Outputs: 'success' (Boolean), 'id' (Int), 'debug': DebugInfo
// *
// ==========================================================================

// Code contributed in part from tutorial at
// w3schools.com/php/php_ajax_database.asp and from guidance at
// www.w3.org/TR/2011/WD-html5-20110525/elements.html
//


// ============================================================================
// Script initialization.
// ============================================================================

// Inclusions.
require_once 'utils.php';

// Script output initialization.
$scriptSuccess = False;
$idOut = -1;
$scriptDebug = NULL;

// Script JSON output format (using above globals).
function scriptOutput()
{
    global $scriptSuccess, $idOut, $scriptDebug;

    $scriptReturn = array('success'=>$scriptSuccess, 'id'=>$idOut, 'debug'=>$scriptDebug);
    echo json_encode($scriptReturn);
}

// Validate parameters.
//if (!array_key_exists('bookName', $_GET))
if (!array_key_exists('bookName', $_POST))
{
    $scriptSuccess = False;
    $idOut = -1;
    $scriptDebug = "No argument for parameter 'bookName'.";

    scriptOutput();
    die();
}

// Constants & static parameters.
$dbName = 'panda_address_book';    // Supply to mysql_select_db().
$tableName = 'address_book';       // Supply in MySQL query.


// ============================================================================
// Grab script arguments and assign default values.
// ============================================================================


function lookupWithDefault($POST_key, $defaultValue)
{
     //TEST:
     //return array_key_exists($POST_key, $_GET) ? $_GET[$POST_key] : $defaultValue;
     return array_key_exists($POST_key, $_POST) ? $_POST[$POST_key] : $defaultValue;
}

$fn = lookupWithDefault('fn', "");
$ln = lookupWithDefault('ln', "");
$addr1 = lookupWithDefault('addr1', "");
$addr2 = lookupWithDefault('addr2 ', "");
$city = lookupWithDefault('city', "");
$st = lookupWithDefault('st', "");
$zip = lookupWithDefault('zip', "");
$ph = lookupWithDefault('ph', "");
$email = lookupWithDefault('email', "");

//TEST:
//$bookName = $_GET['bookName'];
$bookName = $_POST['bookName'];
touchBook($bookName);



// ============================================================================
// Connect to and modify the database.
// ============================================================================

// Call this with debug info if connection fails or database not found.
function accessFail($debug)
{
    global $scriptSuccess, $idOut, $scriptDebug;

    $scriptSuccess = False;
    $idOut = -1;
    $scriptDebug = $debug;
    scriptOutput();
    die();
}


// Connect to the MySQL server process.
//TODO: Use a .cnf file instead of hardcoding the MySQL login.
mysql_connect('ix-trusty:3022','xunl','tbc123bl') or accessFail("Could not connect: " . mysql_error() );

// Select the database containing address books.
mysql_select_db($dbName) or accessFail("Could not find database: " . mysql_error() );

// Test that the specified address book already exists.
doesBookExist($bookName) or accessFail("Could not find address book: " . $bookName);

// Branch: If there is an exact match, set id and go on to return;
//         If there is not, insert the row and get the new id.

// If there is an exact match, return the id (arbitrarily picked if multiple).
// Otherwise, return NULL.
function getIdOfExactMatch($fn, $ln, $city, $st, $zip, $ph, $email, $addr1, $addr2, $bookName)
{
     global $tableName;

     $sql = "SELECT * FROM $tableName
             WHERE first_name = '$fn' AND
             last_name = '$ln' AND
             city = '$city' AND
             state = '$st' AND
             zip = '$zip' AND
             phone = '$ph' AND
             email = '$email' AND
             address_1 = '$addr1' AND
             address_2 = '$addr2' AND
             address_book_ID = '$bookName' ";

     $queryResult = mysql_query($sql);

     if (mysql_num_rows($queryResult) > 0)
     {
          $row = mysql_fetch_assoc($queryResult);
          $id = $row['person_ID'];
          return $id;
     }
     else
          return NULL;
}

// Will be NULL if no duplicate, otherwise id of existing entry.
$idOut = getIdOfExactMatch($fn, $ln, $city, $st, $zip, $ph, $email, $addr1, $addr2, $bookName);

if (is_null($idOut))
{
     // Ok to enter new entry now.

     // Construct & execute MySQL query to add row to the database. (Note: order matters here!)
     $sql = "INSERT INTO $tableName (first_name, last_name, city, state, zip, phone, email, address_1, address_2, address_book_ID) VALUES ('$fn', '$ln', '$city', '$st', '$zip', '$ph', '$email', '$addr1', '$addr2', '$bookName')";
     //$querySuccess = mysql_query($sql);
     mysql_query($sql);

     // Get ID of newly created entry.
     $idOut = getIdOfExactMatch($fn, $ln, $city, $st, $zip, $ph, $email, $addr1, $addr2, $bookName);
}

// Put $idOut inside the overall return object and return JSON encoding of it.
$scriptSuccess = True;
scriptOutput();

// Close connection to the MySQL server process.
mysql_close();

?>
