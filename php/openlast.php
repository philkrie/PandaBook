<?php
include 'utils.php';
$dbName = 'panda_address_book';    // Supply to mysql_select_db().
$tableName = 'book_names'; 

mysql_connect('ix-trusty:3022','xunl','tbc123bl') or die("Could not connect: " . mysql_error() );
mysql_select_db($dbName) or die("Could not find database: " . mysql_error() );

$sql = "SELECT book_name FROM book_names WHERE access_time >= ALL(SELECT access_time FROM book_names);";
$queryResult = mysql_query($sql);
if (!$queryResult) {
    die('Could not query:' . mysql_error());
}

echo mysql_result($queryResult, 0);

?>