<?php

class DaoMapa
{

    private $conexao;

    function __construct()
    {
        try {
            $this->conexao = new PDO("mysql:host=localhost;dbname=daelly", "root", "root");
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
