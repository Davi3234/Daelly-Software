<?php

class DaoFuncao
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

    function inserir(Funcao $funcao)
    {
        try {
            return $this->conexao->exec("insert into funcao (nome, id_tipo) values ('" . $funcao->getNome() . "', '".$funcao->getIdTipo()."' )");
        } catch (PDOException $ex) {
            return false;
        }
    }

    function editar(Funcao $funcao)
    {
        return $this->conexao->exec("update funcao set nome='" . $funcao->getNome() . "' id_tipo = '".$funcao->getIdTipo()."'where id=".$funcao->getId());
    }

    function excluir($id)
    {
        try {
            return $this->conexao->exec("delete from funcao where id=" . $id);
        } catch (PDOException $exc) {
            return false;
        }
    }

    function listar()
    {
        try {
            return $this->conexao->query("select * from funcao", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    function selecionar($id)
    {
        try {
            return $this->conexao->query("select * from funcao where id = " . $id)->fetchObject();
        } catch (PDOException $ex) {
            return false;
        }
    }
}
