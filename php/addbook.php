<?php

// ==========================================================================
// * addbook.php
// *
// * Author:   M.Ishii
// * Project:  PandaBook
// * Date:     2015-10-18
// *
// * Desc.: Adds an address book to the system, ready for new addresses.
// *
// * Inputs:   [POST] 'bookName' (String)
// *
// * Returns:  {'success' (Boolean),
// *            'debug': DebugInfo }
// *
// ==========================================================================


// ============================================================================
// Script initialization.
// ============================================================================

// Inclusions.
require_once 'utils.php';

// Script output initialization.
$scriptSuccess = False;
$scriptDebug = NULL;

// Script JSON output format (using above globals).
function scriptOutput()
{
    global $scriptSuccess, $scriptDebug;

    $scriptReturn = array('success'=>$scriptSuccess, 'debug'=>$scriptDebug);
    echo json_encode($scriptReturn);
}

// Validate parameters.
if (!array_key_exists('bookName', $_POST))
{
    $scriptSuccess = False;
    $scriptDebug = "No argument for parameter 'bookName'.";

    scriptOutput();
    die();
}

// Script GET/POST parameters.
$bookName = $_POST['bookName'];

// Constants & static parameters.
$dbName = 'panda_address_book';    // Supply to mysql_select_db().
$tableName = 'book_names';         // Supply in MySQL query.


// ============================================================================
// Error checking options.
// ============================================================================

// Call this with debug info if connection fails or database not found.
function accessFail($debug)
{
    global $scriptSuccess, $scriptDebug;

    $scriptSuccess = False;
    $scriptDebug = $debug;
    scriptOutput();
    die();
}


// Otherwise, call this with debug info, e.g., in case of attempt to create duplicate.
function otherFail($debug)
{
    global $scriptSuccess, $scriptDebug;

    $scriptSuccess = False;
    $scriptDebug = $debug;
    scriptOutput();
    mysql_close();
    die();
}


// ============================================================================
// Connect to and query the database.
// ============================================================================

// Connect to the MySQL server process.
//TODO: Move login stuff to variables outside the call to mysql_connect.
//TODO: Use a .cnf file instead of hardcoding the MySQL login.
mysql_connect('ix-trusty:3022','xunl','tbc123bl') or accessFail("Could not connect: " . mysql_error() );

// Select the database containing address books.
mysql_select_db($dbName) or accessFail("Could not find database: " . mysql_error() );

// Check for a duplicate before proceeding, returning with error if one is found.
if (doesBookExist($bookName))
{
	otherFail("Duplicate attempt: Address book '$bookName' is already in the system.");
}

// Construct & execute MySQL query to add new book.
$sql = "INSERT INTO $tableName (book_name, access_time) VALUES ('$bookName', NOW())";
if (!mysql_query($sql))
{
	otherFail("MySQL UPDATE query failed.");
}


// ============================================================================
// Ouptut results.
// ============================================================================

// Once we get here, the update is a success.
$scriptSuccess = True;
scriptOutput();


mysql_close();

?>
