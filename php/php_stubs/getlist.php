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

// Used to be: mysqli_connect, mysqli_connect_errno, mysqli_connect_error
//$con = 
mysql_connect('ix-trusty:3022','xunl','tbc123bl') or die("Could not connect: " . mysql_error() ); //,'panda_address_book')
/*if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysql_errno() . PHP_EOL;
    echo "Debugging error: " . mysql_error() . PHP_EOL;
    exit;
    die('Could not connect: ' . mysqli_error($con));
}
*/

// Table header row.
echo "<table>
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
