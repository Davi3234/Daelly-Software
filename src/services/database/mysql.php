<?php

class DatabaseMysql implements Database
{
    private static $instance;
    protected $connection;
    private $isConnected;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new DatabaseMysql();
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
            $this->connection = new PDO("mysql:host=" . $GLOBALS['localhost'] . ";dbname=" . $GLOBALS["dbname"], $GLOBALS["user"], $GLOBALS["pass"]);
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
