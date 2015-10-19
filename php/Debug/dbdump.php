<?php

// ==========================================================================
// * dbdump.php (debugging helper)
// *
// * Author:   M.Ishii
// * Date:     2015-10-17
// *
// * Desc.:  Dumps contents of database into a file and prints filename.
// ==========================================================================

// Code contributed in part from tutorial at
// http://www.php-mysql-tutorial.com/wikis/mysql-tutorials/using-php-to-backup-mysql-databases.aspx
//


// ============================================================================
// Constants/parameters expected to change.
// ============================================================================

$dbname = 'panda_address_book';    // Supply to mysql_select_db().
$tableName = 'address_book';       // Supply in MySQL query.


// ============================================================================
// Connect to the database. (Author unsure whether this is necessary.)
// ============================================================================

// DB credentials.
$dbhost='ix-trusty:3022';
$dbuser='xunl';
$dbpass='tbc123b1';

// Connect to the MySQL server process.
mysql_connect('ix-trusty:3022','xunl','tbc123bl') or die("Could not connect: " . mysql_error() );
//mysql_connect($dbhost, $dbuser, $dbpass) or die("Could not connect: " . mysql_error() );

// Select the database containing address books.
mysql_select_db($dbname) or die("Could not find database: " . mysql_error() );


// ============================================================================
// Perform data dump.
// ============================================================================
$dumpFile = $dbname . '.dump';
$command = "mysqldump --opt -h $dbhost -u $dbuser -p $dbpass $dbname > $dumpFile ";
system($command);


// ============================================================================
// Print name of dump file.
// ============================================================================
echo "Name of dump file is: $dumpFile";

// ============================================================================
// Close connection to the MySQL server process. (Again, unsure if necessary.)
// ============================================================================
mysql_close();
