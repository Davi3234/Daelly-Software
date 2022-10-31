<?php

class DaoFabricante
{

    private $conexao;

    function __construct()
    {
        try {
            $this->conexao = new PDO("mysql:host=localhost;dbname=consertacar", "root", "root");
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
    }

    function inserir(Fabricante $fabricante)
    {
        try {
            return $this->conexao->exec("insert into fabricantes (nome) values ('" . $fabricante->getNome() . "')");
        } catch (PDOException $ex) {
            return false;
        }
    }

    function editar(Fabricante $fabricante)
    {
        return $this->conexao->exec("update fabricantes set nome='" . $fabricante->getNome() . "' where id=" . $fabricante->getId());
    }

    function excluir($id)
    {
        try {
            return $this->conexao->exec("delete from fabricantes where id=" . $id);
        } catch (PDOException $exc) {
            return false;
        }
    }

    function listar()
    {
        try {
            return $this->conexao->query("select * from fabricantes", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    function selecionar($id)
    {
        try {
            return $this->conexao->query("select * from fabricantes where id = " . $id)->fetchObject();
        } catch (PDOException $ex) {
            return false;
        }
    }
}
