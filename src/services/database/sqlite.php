<?php

class DatabaseSqlite implements Database
{
    private static $instance;
    protected $connection;
    private $isConnected;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new DatabaseSqlite();
        }

        return self::$instance;
    }

    private function __constructor()
    {
        $this->connect();
    }

    function connect()
    {
        try {

            $this->connection = new SQLite3($GLOBALS["dbname"] . '.db');
            $this->isConnected  = true;
        } catch (PDOException $ex) {
            $this->isConnected  = false;
            die($ex->getMessage());
        }
    }

    function isConnected()
    {
        return $this->isConnected;
    }
}
