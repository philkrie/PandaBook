<?php

// ==========================================================================
// * utils.php
// *
// * Author:   M.Ishii
// * Project:  PandaBook
// * Date:     2015-10-19
// *
// * Desc.: A collection of functions and objs shared among php source files.
// ==========================================================================


// ==========================================================================
// Module constants.
//
//   (PHP variables are used instead of PHP constants, because
//   the author considers this makes the code more extensible.)
// ==========================================================================
$UTILS_TABLE_NAME = 'book_names';


// ==========================================================================
// doesBookExist()
//
// Pre:     Currently connected to a MySQL server, a database is selected, $UTILS_TABLE_NAME exists.
// Returns: True if $bookName is in the system, otherwise False.
// ==========================================================================
function doesBookExist($bookName)
{
	global $UTILS_TABLE_NAME;

	// Construct & execute MySQL query to detect duplicate.
	//   Look in table $tableName for entries called $bookName.
	$sql = "SELECT * FROM $UTILS_TABLE_NAME WHERE book_name = '$bookName'";
	$queryResult = mysql_query($sql);

	// Return whether the results are nonempty.
	return (mysql_num_rows($queryResult) > 0);
}


// ==========================================================================
// touchBook()
//
// Pre:     Currently connected to a MySQL server, a database is selected, $UTILS_TABLE_NAME exists, $bookName exists.
// Returns: True if the MySQL server performs UPDATE query successfully.
// Post:    The access_time for $bookName is updated to the current datetime.
// ==========================================================================
function touchBook($bookName)
{
	global $UTILS_TABLE_NAME;

	// Construct & execute MySQL query to update access_time field for $bookName.
	//   Look in table $tableName for entries called $bookName, set access_time.
	$sql = "UPDATE $UTILS_TABLE_NAME SET access_time=NOW() WHERE book_name = '$bookName'";
	return mysql_query($sql);
}


?>