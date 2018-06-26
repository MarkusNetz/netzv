<?php
define("HOST", "cpsrv31.misshosting.com");
define("USER", "pjdqirfm_markus");
define("PASSWORD", "i.D!r3kVw0ah");
define("DATABASE", "pjdqirfm_netz");
define("SECURE", TRUE);

$dbConn = new Database();

// First queries to be run to iniate a good connection.
$dbConn->query("SET NAMES utf8mb4");
$dbConn->execute();
$dbConn->query("SET lc_time_names = 'sv_SE'");
$dbConn->execute();
$dbConn->query("SET SESSION sql_mode='". $sqlMode_MariaDB_ver_10_2_4 ."'");
// $dbConn->query("SET SESSION sql_mode='". $sqlMode_MySQL_ver_5_7 ."'");
$dbConn->execute();