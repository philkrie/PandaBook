<?php

// ==========================================================================
// * credentials.php
// *
// * Author:   M.Ishii
// * Project:  PandaBook
// * Date:     2015-10-19
// *
// * Desc.: Checks posted login against username and password in database.
// *
// * Inputs:   [POST] 'user' (String), 'pass' (String)
// *
// * Returns:  {'success' (Boolean),
// *            'loginOk' (Boolean),
// *            'debug': DebugInfo }
// *
// ==========================================================================


// ============================================================================
// Script initialization.
// ============================================================================

// Script output initialization.
$scriptSuccess = False;
$loginOk = False;
$scriptDebug = NULL;

// Script JSON output format (using above globals).
function scriptOutput()
{
    global $scriptSuccess, $loginOk, $scriptDebug;

    $scriptReturn = array('success'=>$scriptSuccess, 'loginOk'=>$loginOk, 'debug'=>$scriptDebug);
    echo json_encode($scriptReturn);
}

// Validate parameters.
//if (!array_key_exists('user', $_GET) or !array_key_exists('pass', $_GET))
if (!array_key_exists('user', $POST) or !array_key_exists('pass', $POST))
{
    $scriptSuccess = False;
    $scriptDebug = "Insufficient login information.";

    scriptOutput();
    die();
}

// Script GET/POST parameters.
//$user = $_GET['user'];
//$pass = $_GET['pass'];
$user = $_POST['user'];
$pass = $_POST['pass'];

// Constants & static parameters.
$dbName = 'panda_address_book';    // Supply to mysql_select_db().
$tableName = 'credentials';         // Supply in MySQL query.


// ============================================================================
// Error checking options.
// ============================================================================

// Call this with debug info if connection fails or database not found.
function accessFail($debug)
{
    global $scriptSuccess, $scriptDebug;

    $scriptSuccess = False;
    $loginOk = NULL;
    $scriptDebug = $debug;
    scriptOutput();
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

// Construct & execute MySQL query to find match(es) for the login.
$sql = "SELECT * FROM $tableName WHERE user = '$user' AND password = '$pass'";   // For some reason, the system does not like the password we chose...
$queryResult = mysql_query($sql);


// ============================================================================
// Ouptut results and finish script.
// ============================================================================

$scriptSuccess = True;
$loginOk = (mysql_num_rows($queryResult) >= 1);    // Count matches.
scriptOutput();

/*
//TEST:
echo mysql_num_rows($queryResult);
*/


mysql_close();

?>
