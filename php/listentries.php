<?php

// ==========================================================================
// * getlist.php (stub)
// *
// * Author:   M.Ishii
// * Date:     2015-10-10
// * Modified: 2015-10-12
// *
// * Desc.:  Returns JSON array of IdName objects for each entry in the
// *         address book, like [{"id":?, "fn":?, "ln":?}, {...}, ...].

// TODO: Insert mysql queries.
// ==========================================================================

// Code contributed in part from tutorial at
// w3schools.com/php/php_ajax_database.asp and from guidance at
// www.w3.org/TR/2011/WD-html5-20110525/elements.html
//


// ============================================================================
// Constants/parameters expected to change.
// ============================================================================

$dbName = 'panda_address_book';    // Supply to mysql_select_db().
$tableName = 'address_book';       // Supply in MySQL query.
// <Define $maxEntriesToReturn.>
// <Define $sortOrder.>


// ============================================================================
// Connect to and query the database.
// ============================================================================

// Connect to the MySQL server process.
//TODO: Use a .cnf file instead of hardcoding the MySQL login.
mysql_connect('ix-trusty:3022','xunl','tbc123bl') or die("Could not connect: " . mysql_error() );

// Select the database containing address books.
mysql_select_db($dbName) or die("Could not find database: " . mysql_error() );

$sort = $_GET['sort'];
$bookName = $_GET['bookName'];
// Construct & execute MySQL query to select rows from the database.
//TODO: Don't assume the field is named last_name, use constant/keyMap below.
if($sort == "name"){
    $sql = "SELECT * FROM $tableName WHERE address_book_ID = '$bookName' ORDER BY last_name";    // Select all.
} else {
    $sql = "SELECT * FROM $tableName WHERE address_book_ID = '$bookName' ORDER BY zip";    // Select all.
}
$queryResult = mysql_query($sql);


// ============================================================================
// Fabricated table data for stub.
// ============================================================================

$fakeTable = array(
    array('id' => 1, 'first_name' => 'Linus', 'last_name' => 'Torvalds'),
    array('id' => 2, 'first_name' => 'Steve', 'last_name' => 'Jobs'),
    array('id' => 3, 'first_name' => 'Bill', 'last_name' => 'Gates'),
    array('id' => 4, 'first_name' => 'Bjarne', 'last_name' => 'Stroustrup'),
    array('id' => 5, 'first_name' => 'Guido', 'last_name' => 'van Rossum')
);


// ============================================================================
// Define extractor/connector code to interface with db naming scheme.
// ============================================================================

// Declare connector to naming scheme of database: keyMap[phpName] == mysqlName
$keyMap = array('id'=>'person_ID', 'firstname'=>'first_name', 'lastname'=>'last_name', 'zip'=>'zip');

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
// Load data into a php array; return from script w/ JSON encoding of array.
// ============================================================================

// Build array of rows like array('id'=>Id, 'fn'=>FirstName, 'ln'=>LastName).

//TODO: Verify interface w/ db, get rid of fakeTable.
//STUB: $entryList = array_map($makeRow, $fakeTable);

$entryList = [];
while($row = mysql_fetch_assoc($queryResult))
{
    $entryList[] = makeRow($row);
}

// Return JSON encoding of entryList; it is unnecessary to build JSON string.
echo json_encode($entryList);

// Close connection to the MySQL server process.
mysql_close();

?>
