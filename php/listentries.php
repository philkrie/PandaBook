<?php

// ==========================================================================
// * listentries.php
// *
// * Author:   M.Ishii
// * Project:  PandaBook
// * Date:     2015-10-10
// * Modified: 2015-10-18
// *
// * Desc.: Yields sorted list of IDs, names, and zip codes from the specified address book.
// *
// * Inputs:   [GET] 'bookName' (String), 'sort' (String)
// *
// * Returns:  {'success' (Boolean),
// *
// *            'entryList': [{'id': (Int),
// *                           'lastname' (String),
// *                           'firstname': (String),
// *                           'zip': (String)},
// *
// *                          {'id': (Int), ...},
// *                          ... ],
// *
// *            'debug': DebugInfo }
// *
// ==========================================================================

// Code contributed in part from tutorial at
// w3schools.com/php/php_ajax_database.asp and from guidance at
// www.w3.org/TR/2011/WD-html5-20110525/elements.html
//


// ============================================================================
// Define extractor/connector code to interface with db naming scheme. (Static)
// ============================================================================

// Declare connector to naming scheme of database: keyMap[phpName] == mysqlName
$keyMap = array('id'=>'person_ID', 'lastname'=>'last_name', 'firstname'=>'first_name', 'zip'=>'zip');

// Input: Row of db table.
// Precondition: The input row has columns named like values of keyMap.
// Output: Copy of input row, except keys renamed to php scheme and columns
//         limited to those listed in keyMap.

$dbRowGlobal;    //  Simulate static scope in nested functions below.
                 //  Probably cleaner to use global approach in 1st place.
function makeRow(&$dbRow)
{
    global $keyMap;
    global $dbRowGlobal;

    //TODO: Figure out how to assign by reference/pointer.
    $dbRowGlobal = $dbRow;

    $getMappedValue = function($mappedKey)
    {
        global $dbRowGlobal;
        return $dbRowGlobal[$mappedKey];
    };

    return array_map($getMappedValue, $keyMap);
}


// ============================================================================
// Script initialization.
// ============================================================================

// Inclusions.
require_once 'utils.php';

// Script output initialization.
$scriptSuccess = False;
$entryList = NULL;
$scriptDebug = NULL;

// Script JSON output format (using above globals).
function scriptOutput()
{
    global $scriptSuccess, $entryList, $scriptDebug;

    $scriptReturn = array('success'=>$scriptSuccess, 'entryList'=>$entryList, 'debug'=>$scriptDebug);
    echo json_encode($scriptReturn);
}

// Validate parameters.
if (!array_key_exists('bookName', $_GET))
{
    $scriptSuccess = False;
    $entryList = NULL;
    $scriptDebug = "No argument for parameter 'bookName'.";

    scriptOutput();
    die();
}

// Script GET/POST parameters.
$bookName = $_GET['bookName'];
$sort = array_key_exists('sort', $_GET) ? $_GET['sort'] : 'name';  // Defaults to 'name'.

// Constants & static parameters.
$dbName = 'panda_address_book';    // Supply to mysql_select_db().
$tableName = 'address_book';       // Supply in MySQL query.

// WISHLIST: <Define $maxEntriesToReturn.>


// ============================================================================
// Connect to and query the database.
// ============================================================================

// Determine DB field to sort by. (So these are DB field names.)
switch ($sort)
    //TODO?: Don't assume the field is named last_name, use constant/keyMap below.
{
    case 'name':
        $sortOrder = 'last_name';
        break;
    case 'zip':
        $sortOrder = 'zip';
        break;
    default:
        $sortOrder = 'last_name';
}

// Call this with debug info if connection fails or database not found.
function accessFail($debug)
{
    global $scriptSuccess, $entryList, $scriptDebug;

    $scriptSuccess = False;
    $entryList = NULL;
    $scriptDebug = $debug;
    scriptOutput();
    die();
}

// Connect to the MySQL server process.
//TODO: Move login stuff to variables outside the call to mysql_connect.
//TODO: Use a .cnf file instead of hardcoding the MySQL login.
mysql_connect('ix-trusty:3022','xunl','tbc123bl') or accessFail("Could not connect: " . mysql_error() );

// Select the database containing address books.
mysql_select_db($dbName) or accessFail("Could not find database: " . mysql_error() );

// Test that the specified address book already exists.
doesBookExist($bookName) or accessFail("Could not find address book: " . $bookName);

// Construct & execute MySQL query to select rows from the database.
//   Look in table $tableName for entries in book $bookName, sorted by $sortOrder.
$sql = "SELECT * FROM $tableName WHERE address_book_ID = '$bookName' ORDER BY $sortOrder";    // Select all, sorted.
$queryResult = mysql_query($sql);


// ============================================================================
// Load data into a php array; return from script w/ JSON encoding of array.
// ============================================================================

// Build array of rows like array('id'=>Id, 'ln'=>LastName, 'fn'=>FirstName, 'zip'=>Zip).
$entryList = [];
while($row = mysql_fetch_assoc($queryResult))
{
    $entryList[] = makeRow($row);
}

// Put entryList inside the overall return object and return JSON encoding of it.
$scriptSuccess = True;
scriptOutput();

// Close connection to the MySQL server process.
mysql_close();


?>
