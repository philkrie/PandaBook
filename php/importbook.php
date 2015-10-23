<?php
    //Upload File
$dbName = 'panda_address_book';    // Supply to mysql_select_db().
$tableName = 'address_book'; 

mysql_connect('ix-trusty:3022','xunl','tbc123bl') or die("Could not connect: " . mysql_error() );
mysql_select_db($dbName) or die("Could not find database: " . mysql_error() );

$mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv', 'text/tab-separated-values');
if(in_array($_FILES['tsv']['type'],$mimes)){
  // do something




if (isset($_POST['submit'])) {
    if (is_uploaded_file($_FILES['tsv']['tmp_name'])) {
        echo "<h1>" . "File ". $_FILES['tsv']['name'] ." uploaded successfully." . "</h1>";

        echo "<h2>Displaying contents:</h2>";
        readfile($_FILES['tsv']['tmp_name']);
   }

 
    //Import uploaded file to Database
    $filename = pathinfo($_FILES['tsv']['name'], PATHINFO_FILENAME);
    $handle = fopen($_FILES['tsv']['tmp_name'], "r");
    
    $sql = "INSERT INTO book_names (book_name, access_time) VALUES ('$filename', NOW())";
    mysql_query($sql) or die(mysql_error());

 
    $data = fgetcsv($handle, 1000, "\t");
    
    while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE) {

        $import="INSERT into $tableName(last_name,first_name,city,state,zip,phone,email,address_1,address_2, address_book_ID) values('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$data[8]','$filename')";

 

        mysql_query($import) or die(mysql_error());

    }
 

    fclose($handle);
 

    echo '</br>Import complete </br>';

    echo '</br><h2>Please close this tab to return to your books!<h2> </br>';

    //view upload form
}
    
} else {
    echo "FAILURE";
    header("HTTP/1.1 404 Not Found");
  die("Sorry, mime type not allowed");
}
?>