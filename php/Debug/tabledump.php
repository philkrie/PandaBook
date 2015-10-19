<?php

// ==========================================================================
// * listentries.php
// *
// * Author:   M.Ishii
// * Project:  PandaBook
// * Date:     2015-10-18
// *
// * Desc.: Debugging tool to see all data in a table.
// *
// * Inputs:   [GET] 'table' (name of the table).
// *
// * Returns:  Raw text. Table rows are separated by '<br>'.
// *
// * TODO: Move login information to a protected config file!
// * TODO: Remove this file from the live site!
// ==========================================================================


// ============================================================================
// Get parameters.
// ============================================================================

if (!array_key_exists('table', $_GET))
{
	echo 'Please supply an argument to the parameter: tabledump.php?table= ...';
	die();
}

$tableName = $_GET['table'];


// ============================================================================
// Static parameters.
// ============================================================================

$dbName = 'panda_address_book';

// ============================================================================
// Open DB connection.
// ============================================================================

mysql_connect('ix-trusty:3022','xunl','tbc123bl') or die("Could not connect: " . mysql_error() );
mysql_select_db($dbName) or die("Could not find database: " . mysql_error() );


// ============================================================================
// Execute a MySQL query to select data of entire table.
// ============================================================================

$sql = "SELECT * FROM $tableName";    // Select all.
$queryResult = mysql_query($sql);


// ============================================================================
// Dump rows to screen.
// ============================================================================

while($row = mysql_fetch_assoc($queryResult))
{
	print_r($row);
	echo '<br>';
}


// ============================================================================
// Close DB connection.
// ============================================================================

mysql_close();

?>