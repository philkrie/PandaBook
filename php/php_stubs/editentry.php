<!DOCTYPE html>

<!-- ==========================================================================
     * editentry.php (stub)
     *
     * Author: M.Ishii
     * Date:   2015-10-10
     *
     * Desc.:  Given arguments for id, fn, ln, city, st, zip, ph, and email
     *         (id, first name, last name, city, state, zip, phone, and email)
     *         looks up the entry in the address book database table having the
     *         specified id and replaces the values in all fields with the new
     *         arguments. No data is returned. For this stub though, the
     *         database is not accessed, and debug info is returned in an HTML
     *         element.
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
$id = array_key_exists('id', $_GET) ? $_GET['id'] : 999;
$fn = array_key_exists('fn', $_GET) ? $_GET['fn'] : "";
$ln = array_key_exists('ln', $_GET) ? $_GET['ln'] : "";
$city = array_key_exists('city', $_GET) ? $_GET['city'] : "";
$st = array_key_exists('st', $_GET) ? $_GET['st'] : "";
$zip = array_key_exists('zip', $_GET) ? $_GET['zip'] : "";
$ph = array_key_exists('ph', $_GET) ? $_GET['ph'] : "";
$email = array_key_exists('email', $_GET) ? $_GET['email'] : "";

// <Update row with above id using above info to table.>

// For this stub, print out debug info.
echo "<p> id=$id fn=$fn ln=$ln city=$city st=$st zip=$zip ph=$ph email=$email </p>";

?>
</body>
</html>
