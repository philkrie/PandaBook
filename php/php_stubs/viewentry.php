<!DOCTYPE html>

<!-- ==========================================================================
     * viewentry.php (stub)
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

<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
</head>
<body>

<?php

// Grab URL parameter.
$id = intval($_GET['id']);

// Table header row.
echo "<table id='entryInfoTable'>
<tr>
<!-- <th>Person ID</th> -->
<th>Firstname</th>
<th>Lastname</th>
<th>City</th>
<th>State</th>
<th>Zip</th>
<th>Phone</th>
<th>Email</th>
</tr>";

// Fabricated table data for stub.
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

// Table data row.
// Thanks to HTML 5, can define data-personid and access from Javascript. 
echo "<tr data-personid=" . ($row['id']) . ">";
echo "<td>" . $row['first_name'] . "</td>";
echo "<td>" . $row['last_name'] . "</td>";
echo "<td>" . $row['city'] . "</td>";
echo "<td>" . $row['state'] . "</td>";
echo "<td>" . $row['zip'] . "</td>";
echo "<td>" . $row['phone'] . "</td>";
echo "<td>" . $row['email'] . "</td>";
echo "</tr>";

echo "</table>";

?>
</body>
</html>
