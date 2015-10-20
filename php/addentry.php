

<?php

/*
<!-- ==========================================================================
     * addentry.php
     *
     * Author: M.Ishii
     * Date:   2015-10-10
     *
     * Desc.:  Given arguments for fn, ln, city, st, zip, ph, and email
     *         (first name, last name, city, state, zip, phone, and email)
     *         creates a new entry in the address book database table and
     *         returns the id of the new entry. For this stub, the database is
     *         not accessed; returned data is hard-coded.
     *
     * How to access returned data: There is a div element with attribute
     * id=personidHolder and custom attribute data-personid (type: int)
     * indicating the entry of the new row. In this stub, returned ids are
     * not guaranteed to be unique.
     ==========================================================================
-->

<!-- Code contributed in part from tutorial at
     w3schools.com/php/php_ajax_database.asp and from guidance at
     www.w3.org/TR/2011/WD-html5-20110525/elements.html
-->
*/


// ============================================================================
// Constants/parameters expected to change.
// ============================================================================

$dbName = 'panda_address_book';    // Supply to mysql_select_db().
$tableName = 'address_book';       // Supply in MySQL query.


// ============================================================================
// Grab URL arguments, assuming _POST was used.
// ============================================================================
//TODO: determine whether this error checking should be done here.

$bookName = array_key_exists('bookName', $_POST) ? $_POST['bookName'] : "";
$fn = array_key_exists('fn', $_POST) ? $_POST['fn'] : "";
$ln = array_key_exists('ln', $_POST) ? $_POST['ln'] : "";
$city = array_key_exists('city', $_POST) ? $_POST['city'] : "";
$st = array_key_exists('st', $_POST) ? $_POST['st'] : "";
$zip = array_key_exists('zip', $_POST) ? $_POST['zip'] : "";
$ph = array_key_exists('ph', $_POST) ? $_POST['ph'] : "";
$email = array_key_exists('email', $_POST) ? $_POST['email'] : "";

//TODO: Grab address 1 and address 2 from _POST param list.
$addr1 = "Test1"; // address line 1.";
$addr2 = "Test2"; // address line 2.";


// ============================================================================
// Connect to and modify the database.
// ============================================================================

// Connect to the MySQL server process.
//TODO: Use a .cnf file instead of hardcoding the MySQL login.
mysql_connect('ix-trusty:3022','xunl','tbc123bl') or die("Could not connect: " . mysql_error() );

// Select the database containing address books.
mysql_select_db($dbName) or die("Could not find database: " . mysql_error() );


// Construct & execute MySQL query to add row to the database.
//TODO: Don't assume the field is named last_name, use constant/keyMap below.
//TODO: Use keyMap or something.
//TODO: Put in addr1, addr2.

$sql = "INSERT INTO $tableName (first_name, last_name, city, state, zip, phone, email) VALUES ('$fn', '$ln', '$city', '$st', '$zip', '$ph', '$email')";
$querySuccess = mysql_query($sql);


// On success: return True. On failure: return False.
echo json_encode($querySuccess);   // Assumes that mysql_query has returned a bool.

mysql_close();

?>
