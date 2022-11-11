<?php

class DaoGrupo
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

    function inserir(Grupo $grupo)
    {
        try {
            return $this->conexao->exec("insert into grupo (numero) values ('" . $grupo->getNumero() . "' )");
        } catch (PDOException $ex) {
            return false;
        }
    }

    function editar(Grupo $grupo)
    {
        $this->conexao->exec("update grupo set numero='" . $grupo->getNumero() . "' where id=" . $grupo->getId());
        return true;
    }

    function excluir($id)
    {
        try {
            return $this->conexao->exec("delete from grupo where id=" . $id);
        } catch (PDOException $exc) {
            return false;
        }
    }

    function listar()
    {
        try {
            return $this->conexao->query("select * from grupo", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    function selecionar($id)
    {
        try {
            return $this->conexao->query("select * from grupo where id = " . $id)->fetchObject();
        } catch (PDOException $ex) {
            return false;
        }
    }
}
