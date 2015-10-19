<?php

include_once '../utils.php';

$dbName = 'panda_address_book';
mysql_connect('ix-trusty:3022','xunl','tbc123bl') or accessFail("Could not connect: " . mysql_error() );
mysql_select_db($dbName) or accessFail("Could not find database: " . mysql_error() );

/*
$tableName = 'book_names';
$sql = "SELECT * FROM $tableName";    // Select all, sorted.
$queryResult = mysql_query($sql);

while($row = mysql_fetch_assoc($queryResult))
{
	print_r($row);
	echo '<br>';
}
*/

echo ( doesBookExist('my friends') ? 'my friends' : 'stop 1' );
echo '<br>';
echo ( doesBookExist('friends contacts') ? 'friends contacts' : 'stop 2' );
echo '<br>';
echo ( touchBook('friends contacts') ? 'friends contacts' : 'stop 3' );

mysql_close();

?>