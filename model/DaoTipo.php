<?php

class DaoTipo
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

    function inserir(Tipo $tipo)
    {
        try {
            return $this->conexao->exec("insert into tipo (nome) values ('" . $tipo->getNome() . "' )");
        } catch (PDOException $ex) {
            return false;
        }
    }

    function editar(Tipo $tipo)
    {
        $this->conexao->exec("update tipo set nome='" . $tipo->getNome() . "'where id=".$tipo->getId());
        return true;
    }

    function excluir($id)
    {
        try {
            return $this->conexao->exec("delete from tipo where id=" . $id);
        } catch (PDOException $exc) {
            return false;
        }
    }

    function listar()
    {
        try {
            return $this->conexao->query("select * from tipo order by id desc", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    function selecionar($id)
    {
        try {
            return $this->conexao->query("select * from tipo where id = " . $id)->fetchObject();
        } catch (PDOException $ex) {
            return false;
        }
    }

    function selecionarByNome($nome)
    {
        try {
            return $this->conexao->query("select * from tipo where nome = '" . $nome . "'")->fetchObject();
        } catch (PDOException $ex) {
            return false;
        }
    }
}
