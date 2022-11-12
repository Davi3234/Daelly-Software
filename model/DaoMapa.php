<?php

class DaoMapa
{

    private $conexao;

    function __construct()
    {
        try {
            include "../config/db-config.php";
            $this->conexao = new PDO("mysql:host=localhost;dbname=" . $GLOBALS["dbname"], $GLOBALS["user"], $GLOBALS["pass"]);
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
    }

    function selecionar()
    {
        try {
            return $this->conexao->query("select * from mapa limit 1")->fetchObject();
        } catch (PDOException $ex) {
            return false;
        }
    }
}
