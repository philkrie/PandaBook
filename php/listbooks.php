<?php
include 'utils.php';
$dbName = 'panda_address_book';    // Supply to mysql_select_db().
$tableName = 'book_names';  

mysql_connect('ix-trusty:3022','xunl','tbc123bl') or die("Could not connect: " . mysql_error() );
mysql_select_db($dbName) or die("Could not find database: " . mysql_error() );

$sql = "SELECT DISTINCT book_name FROM $tableName";
$queryResult = mysql_query($sql);

$keyMap = array('bookName'=>'book_name');

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