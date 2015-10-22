<?php
// Connect and query the database for the users
$dbName = 'panda_address_book';    // Supply to mysql_select_db().
$tableName = 'address_book'; 

mysql_connect('ix-trusty:3022','xunl','tbc123bl') or die("Could not connect: " . mysql_error() );
mysql_select_db($dbName) or die("Could not find database: " . mysql_error() );

$bookName= urldecode($_GET['bookName']);
$sql = "SELECT * FROM $tableName WHERE address_book_ID = '$bookName'";


$results = mysql_query($sql);

if (!$results) {
    die('Could not query:' . mysql_error());
}

$filename = $bookName.".tsv";// Remember that the folder where you want to write the file has to be writable

                                          // Actually create the file
$handle = fopen($filename, 'w+');// The w+ parameter will wipe out and overwrite any existing file with the same name



// Write the spreadsheet column titles / labels
fputcsv($handle, array('last_name','first_name','city','state','zip','phone','email','address_1','address_2'), "\t");
 
// Write all the user records to the spreadsheet
while($row = mysql_fetch_array($results))
{
    fputcsv($handle, array($row['last_name'], $row['first_name'],$row['city'],$row['state'],$row['zip'], $row['phone'], $row['email'],$row['address_1'],$row['address_2']), "\t");
}

//download file
@header('Content-Type: application/tsv; charset=utf-8');
@header('Content-Disposition: attachment; filename="'.$bookName.'.tsv"');
echo readfile($filename);

?>
