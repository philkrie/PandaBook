<?php
include 'utils.php';

/*<!DOCTYPE html>

<!-- ==========================================================================
     * deleteentry.php (stub)
     *
     * Author: M.Ishii
     * Date:   2015-10-10
     *
     * Desc.:  Given the id of an existing entry, deletes entry from the
     *         address book database table having that id. Nothing is returned.
     *         For this stub though, the database is not accessed, and debug
     *         info is returned in an HTML <p> element.
     ==========================================================================
-->

<!-- Code contributed in part from tutorial at
     w3schools.com/php/php_ajax_database.asp and from guidance at
     www.w3.org/TR/2011/WD-html5-20110525/elements.html
--> */


// Grab URL parameter.
$id = intval($_POST['id']);

// Fabricated table data for stub debug.
/*
$entryList = array(
    array('id'=>999, 'first_name'=>'Null', 'last_name'=>'Null', 'city'=>'Null', 'state'=>'Null', 'zip'=>'Null', 'phone'=>'Null', 'email'=>'Null'),
    array('id'=>1, 'first_name'=>'Linus', 'last_name'=>'Torvalds', 'city'=>'Helsinki', 'state'=>'MD', 'zip'=>'11111', 'phone'=>'1234567890', 'email'=>'a1@example.net'),
    array('id'=>2, 'first_name'=>'Steve', 'last_name'=>'Jobs', 'city'=>'Germantown', 'state'=>'WI', 'zip'=>'22222', 'phone'=>'2345678901', 'email'=>'b2@example.net'),
    array('id'=>3, 'first_name'=>'Bill', 'last_name'=>'Gates', 'city'=>'Seattle', 'state'=>'WA', 'zip'=>'33333', 'phone'=>'3456789012', 'email'=>'c3@example.net'),
    array('id'=>4, 'first_name'=>'Bjarne', 'last_name'=>'Stroustrup', 'city'=>'Aarhus', 'state'=>'ID', 'zip'=>'44444', 'phone'=>'4567890123', 'email'=>'d4@example.net'),
    array('id'=>5, 'first_name'=>'Guido', 'last_name'=>'van Rossum', 'city'=>'Belmont', 'state'=>'CA', 'zip'=>'55555', 'phone'=>'5678901234', 'email'=>'e5@example.net')
);
*/

// <Validate given id.>
// For this stub, verify (1 <= id <= 5), or else fields get filled with 'Null'.

/*
if ($id < 1 or $id > 5)
    echo "id $id not found in the 'database'";
else
{
    $row = $entryList[$id];
    echo "'Deleting' entry";
    echo "<p> id=${row['id']} first_name=${row['first_name']} last_name=${row['last_name']} city=${row['city']} state=${row['state']} zip=${row['zip']} phone=${row['phone']} email=${row['email']} </p>";
} */


$dbName = 'panda_address_book';    // Supply to mysql_select_db().
$tableName = 'address_book';  

mysql_connect('ix-trusty:3022','xunl','tbc123bl') or die("Could not connect: " . mysql_error() );
mysql_select_db($dbName) or die("Could not find database: " . mysql_error() );


$sql = "DELETE FROM $tableName WHERE person_ID = $id";
$querySuccess = mysql_query($sql);

if($querySuccess){
    $json = array('boolean' => true);
} else {
    $json = array('boolean' => false);
}

echo json_encode($json);   // Assumes that mysql_query has returned a bool.

mysql_close();


?>
