<!DOCTYPE html>

<!-- ==========================================================================
     * createentry.php (stub)
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

<html>
<head> </head>
<body>

<?php

// Grab URL arguments, assuming _GET was used.
$fn = array_key_exists('fn', $_GET) ? $_GET['fn'] : "";
$ln = array_key_exists('ln', $_GET) ? $_GET['ln'] : "";
$city = array_key_exists('city', $_GET) ? $_GET['city'] : "";
$st = array_key_exists('st', $_GET) ? $_GET['st'] : "";
$zip = array_key_exists('zip', $_GET) ? $_GET['zip'] : "";
$ph = array_key_exists('ph', $_GET) ? $_GET['ph'] : "";
$email = array_key_exists('email', $_GET) ? $_GET['email'] : "";

// <Add row with above info to table, get new id.>
// For this stub, just make up an id.
$id = 7*15*(strlen($fn) + 1) + 15*(strlen($ln) + 1) + strlen($email);

// Return the id as a custom attribute of an (invisible) div.
// For this stub, print out debug info as well.
echo "<div id='personidHolder' data-personid=$id>";
echo "<p> id=$id fn=$fn ln=$ln city=$city st=$st zip=$zip ph=$ph email=$email </p>";
echo "</div>";

?>
</body>
</html>
