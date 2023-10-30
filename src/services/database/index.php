<?php

require_once 'config/database-config.php';
require_once 'database.php';

/** @var Database $database */
$database;

if ($GLOBALS['provider'] == 'mysql') {
    require_once 'mysql.php';

    $database = DatabaseMysql::getInstance();
} else if ($GLOBALS['provider'] == 'sqlite3') {
    require_once 'sqlite.php';

    $database = DatabaseSqlite::getInstance();
}

$database->connect();