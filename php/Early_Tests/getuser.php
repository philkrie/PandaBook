<!DOCTYPE html>
<!--Code copied from w3schools.com/php/php_ajax_database.asp-->
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
$q = intval($_GET['q']);

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


// Used to be: mysqli_select_db($con, "panda_address_book");
$db_select_success = mysql_select_db("panda_address_book");
echo "Selection success: " . (db_select_success ? "Success" : "Fail");

$sql="SELECT * FROM address_book"; // WHERE person_ID = '".$q."'";
echo "Query is: " . $sql;
// Used to be: mysqli_query
$result = mysql_query("SELECT * FROM address_book");

if ($result)
{
    echo "result success.";
}
else
{
    echo "result fail.";
}

echo "<table>
<tr>
<th>Firstname</th>
<th>Lastname</th>
<th>City</th>
<th>State</th>
<th>Zip</th>
<th>Phone</th>
<th>Email</th>
<!-- <th>Person ID</th> -->
</tr>";

//TEST
//$row = mysql_fetch_array($result, MYSQL_NUM);
//echo "Go go go...";
//echo $result;

// Used to be: mysqli_fetch_array
while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row['first_name'] . "</td>";
    echo "<td>" . $row['last_name'] . "</td>";
    echo "<td>" . $row['city'] . "</td>";
    echo "<td>" . $row['state'] . "</td>";
    echo "<td>" . $row['zip'] . "</td>";
    echo "<td>" . $row['phone'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "</tr>";
}
echo "</table>";
// Used to be: mysqli_close
mysql_close($con);
?>
</body>
</html>
