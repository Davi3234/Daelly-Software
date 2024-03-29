<?php

class DaoCompressor
{

    private $conexao;

    function __construct()
    {
        try {
            include "../../config/db-config.php";
            $this->conexao = new PDO("mysql:host=localhost;dbname=" . $GLOBALS["dbname"], $GLOBALS["user"], $GLOBALS["pass"]);
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
    }

    function inserir(Compressor $compressor)
    {
        try {
            return $this->conexao->exec("insert into compressor (codigo, marca, modelo) values (" . $compressor->getCodigo() . ", '" . $compressor->getMarca() . "', '" . $compressor->getModelo() . "')");
        } catch (PDOException $ex) {
            return false;
        }
    }

    function editar(Compressor $compressor)
    {
        try {
            $this->conexao->exec("update grupo set codigo=" . $compressor->getCodigo() . " marca = '" . $compressor->getMarca() . "' modelo = '" . $compressor->getModelo() . "'where id=" . $compressor->getId());
            return true;
        } catch (PDOException $exe) {
            return false;
        }
    }

    function excluir($id)
    {
        try {
            return $this->conexao->exec("delete from compressor where id=" . $id);
        } catch (PDOException $exc) {
            return false;
        }
    }

    function listar()
    {
        try {
            return $this->conexao->query("select * from compressor order by id desc", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    function selecionar($id)
    {
        try {
            return $this->conexao->query("select * from compressor where id = " . $id)->fetchObject();
        } catch (PDOException $ex) {
            return false;
        }
    }

    function selecionarByCodigo($codigo)
    {
        try {
            return $this->conexao->query("select * from compressor where codigo = " . $codigo)->fetchObject();
        } catch (PDOException $ex) {
            return false;
        }
    }
}
