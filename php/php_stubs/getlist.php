<!DOCTYPE html>

<!-- ==========================================================================
     * getlist.php (stub)
     *
     * Author: M.Ishii
     * Date:   2015-10-10
     *
     * Desc.:  Returns HTML table of Firstname, Lastname pairs for all entries
     *         in the address book database table. For this stub, the database
     *         is not accessed; returned data is hard-coded.
     *
     * How to access returned data: The returned table has id='entryListTable'
     *     and each row (except header row) has the custom attribute
     *     data-personid (type: int) indicating the id of the entry.
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

// Table header row.
echo "<table id='entryListTable'>
<tr>
<!-- <th>Person ID</th> -->
<th>Firstname</th>
<th>Lastname</th>
</tr>";

// Table data for stub.
$entryList = array(
    array('id' => 1, 'first_name' => 'Linus', 'last_name' => 'Torvalds'),
    array('id' => 2, 'first_name' => 'Steve', 'last_name' => 'Jobs'),
    array('id' => 3, 'first_name' => 'Bill', 'last_name' => 'Gates'),
    array('id' => 4, 'first_name' => 'Bjarne', 'last_name' => 'Stroustrup'),
    array('id' => 5, 'first_name' => 'Guido', 'last_name' => 'van Rossum')
);

// Table data rows.
foreach ($entryList as $row) {
    // Thanks to HTML 5, can define data-personid and access from Javascript. 
    echo "<tr data-personid=" . ($row['id']) . ">";
    echo "<td>" . $row['first_name'] . "</td>";
    echo "<td>" . $row['last_name'] . "</td>";
    echo "</tr>";
}
echo "</table>";

?>
</body>
</html>
