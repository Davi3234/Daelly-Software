<?php

require_once 'config/database-config.php';
require_once 'database.php';

class Repository
{
    private static $instance;
    static function getInstance()
    {
        if (isset(self::$instance)) {
            return self::$instance;
        }

        /** @var Database $database */
        $database;

        if ($GLOBALS['DATABASE']['provider'] == 'mysql') {
            require_once 'mysql.php';

            $database = DatabaseMysql::getInstance();
        } else if ($GLOBALS['DATABASE']['provider'] == 'sqlite3') {
            require_once 'sqlite.php';

            $database = DatabaseSqlite::getInstance();
        }

        $database->connect();

        self::$instance = $database;

        return self::$instance;
    }
}
