<?php

class DatabaseMysql implements Database
{
    private static $instance;
    protected $connection;
    private $isConnected;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function connect()
    {
        Session::getInstance()->removeItem('DATABASE');
        if (Session::getInstance()->setItem('isConnected', 'DATABASE')) {
            $this->connection = Session::getInstance()->setItem('connection', 'DATABASE');

            return;
        }

        try {
            $this->connection = new PDO("mysql:host=" . $GLOBALS['localhost'] . ";dbname=" . $GLOBALS["dbname"], $GLOBALS["user"], $GLOBALS["pass"]);
            Session::getInstance()->setItem('isConnected', true, 'DATABASE');
            Session::getInstance()->setItem('connection', $this->connection, 'DATABASE');
        } catch (PDOException $ex) {
            Session::getInstance()->setItem('isConnected', false, 'DATABASE');
            die($ex->getMessage());
        }
    }

    function exec($sql) {
        
    }

    function query($sql) {
        
    }

    function isConnected()
    {
        return Session::getInstance()->setItem('isConnected', 'DATABASE');
    }
}
