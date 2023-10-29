<?php

class Database
{
    private static $instance;
    private PDO $connection;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    private function __construct()
    {
        $this->connection();
    }

    function connection()
    {
        try {
            require_once 'config/database-config.php';

            $this->connection = new PDO("mysql:host=localhost;dbname=" . $GLOBALS["dbname"], $GLOBALS["user"], $GLOBALS["pass"]);
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
    }

    public function getTables()
    {
        try {
            return $this->connection->query("select * from administrador", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }
}
