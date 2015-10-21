<?php

//TODO: reformat comments.
/*
<!-- ==========================================================================
     * viewentry.php
     *
     * Author: M.Ishii
     * Date:   2015-10-10
     *
     * Desc.:  Given the id of an existing entry, returns HTML table of
     *         Firstname, Lastname, City, State, Zip, Phone, Email for that
     *         entry from the address database table. For this stub, the
     *         database is not accessed; returned data is hard-coded.
     *
     * How to access returned data: The returned table has id='entryInfoTable',
     *     a header row, and a data row. The data row has the custom attribute
     *     data-personid (type:int) indicating the id of the entry.
     ==========================================================================
-->

<!-- Code contributed in part from tutorial at
     w3schools.com/php/php_ajax_database.asp and from guidance at
     www.w3.org/TR/2011/WD-html5-20110525/elements.html
-->
*/

//TODO:
//require(makerow.php);

// ============================================================================
// Constants/parameters expected to change.
// ============================================================================

$dbName = 'panda_address_book';    // Supply to mysql_select_db().
$tableName = 'address_book';       // Supply in MySQL query.


// ============================================================================
// Grab URL parameter.
// ============================================================================
$id = intval($_GET['id']);
$bookName = $_GET['bookName'];


// ============================================================================
// Connect to and query the database.
// ============================================================================

// Connect to the MySQL server process.
//TODO: Use a .cnf file instead of hardcoding the MySQL login.
mysql_connect('ix-trusty:3022','xunl','tbc123bl') or die("Could not connect: " . mysql_error() );

// Select the database containing address books.
mysql_select_db($dbName) or die("Could not find database: " . mysql_error() );

// Construct & execute MySQL query to select rows from the database.
//TODO: Don't assume the field is named last_name, use constant/keyMap below.
$sql = "SELECT * FROM $tableName WHERE person_ID = '$id' AND address_book_ID = '$bookName'";  // Select entry w/ specified id.
//$sql = "SELECT * FROM $tableName ORDER BY last_name";    // Select all.
$queryResult = mysql_query($sql);


// ============================================================================
// Fabricated table data for stub.
// ============================================================================

/*
$entryList = array(
    array('id'=>999, 'first_name'=>'Null', 'last_name'=>'Null', 'city'=>'Null', 'state'=>'Null', 'zip'=>'Null', 'phone'=>'Null', 'email'=>'Null'),
    array('id'=>1, 'first_name'=>'Linus', 'last_name'=>'Torvalds', 'city'=>'Helsinki', 'state'=>'MD', 'zip'=>'11111', 'phone'=>'1234567890', 'email'=>'a1@example.net'),
    array('id'=>2, 'first_name'=>'Steve', 'last_name'=>'Jobs', 'city'=>'Germantown', 'state'=>'WI', 'zip'=>'22222', 'phone'=>'2345678901', 'email'=>'b2@example.net'),
    array('id'=>3, 'first_name'=>'Bill', 'last_name'=>'Gates', 'city'=>'Seattle', 'state'=>'WA', 'zip'=>'33333', 'phone'=>'3456789012', 'email'=>'c3@example.net'),
    array('id'=>4, 'first_name'=>'Bjarne', 'last_name'=>'Stroustrup', 'city'=>'Aarhus', 'state'=>'ID', 'zip'=>'44444', 'phone'=>'4567890123', 'email'=>'d4@example.net'),
    array('id'=>5, 'first_name'=>'Guido', 'last_name'=>'van Rossum', 'city'=>'Belmont', 'state'=>'CA', 'zip'=>'55555', 'phone'=>'5678901234', 'email'=>'e5@example.net')
);

// <Validate given id.>
// For this stub, verify (1 <= id <= 5), or else fields get filled with 'Null'.
if ($id < 1 or $id > 5)
    $id = 0;
$row = $entryList[$id];
*/


// ============================================================================
// Define extractor/connector code to interface with db naming scheme.
// ============================================================================

// Declare connector to naming scheme of database: keyMap[phpName] == mysqlName
$keyMap = array('id'=>'person_ID', 'firstname'=>'first_name', 'lastname'=>'last_name', 'addr1'=>'address_1', 'addr2'=>'address_2', 'city'=>'city', 'state'=>'state', 'zip'=>'zip', 'phone'=>'phone', 'email'=>'email');

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

//STUB: $entryList = array_map($makeRow, $fakeTable);

$mysqlRow = mysql_fetch_assoc($queryResult);
$phpRow = makeRow($mysqlRow);
$phpArray = [$phpRow];

// Return JSON encoding of entryList; it is unnecessary to build JSON string.
echo json_encode($phpArray);

// Close connection to the MySQL server process.
mysql_close();


?>
