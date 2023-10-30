<?php

class DatabaseSqlite implements Database
{
    private static $instance;
    protected $connection;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function connect()
    {
        try {
            $this->connection = new SQLite3('storage/' . $GLOBALS["dbname"] . '.db');
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
    }

    function exec($sql) {
        return $this->connection->exec($sql);
    }

    function query($sql) {
        $res = $this->connection->query($sql);

        $docs = [];

        while ($row = $res->fetchArray()) {
            $docs[] = $row;
        }

        return $docs;
    }
}