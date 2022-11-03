<?php

class DaoTipo
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
        return $this->conexao->exec("update tipo set nome='" . $tipo->getNome() . "'where id=".$tipo->getId());
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
            return $this->conexao->query("select * from tipo", PDO::FETCH_OBJ);
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
}