<?php

class DaoMaquinaCostura
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

    function inserir(MaquinaCostura $maquina)
    {
        try {
            return $this->conexao->exec("insert into maquina_costura (id_tipo, codigo, modelo, marca, chassi, aquisicao) values ('" . $maquina->getId_tipo() . "' , '" . $maquina->getCodigo() . "' , '" . $maquina->getModelo() . "' , '" . $maquina->getMarca() . "', '" . $maquina->getChassi() . "', '" . $maquina->getAquisicao() . "')");
        } catch (PDOException $ex) {
            return false;
        }
    }

    function editar(MaquinaCostura $maquina)
    {
        $this->conexao->exec("update maquina_costura set id_tipo = " . $maquina->getId_tipo() . ", codigo = '" . $maquina->getCodigo() . "', modelo = '" . $maquina->getModelo() . "', marca = '" . $maquina->getMarca() . "', chassi = '" . $maquina->getChassi() . "', aquisicao = '" . $maquina->getAquisicao() . "' where id=" . $maquina->getId());
        return true;
    }

    function excluir($id)
    {
        try {
            return $this->conexao->exec("delete from maquina_costura where id=" . $id);
        } catch (PDOException $exc) {
            return false;
        }
    }

    function listar()
    {
        try {
            return $this->conexao->query("select mc.*, tip.nome as tipo from maquina_costura mc join tipo tip on mc.id_tipo = tip.id order by mc.aquisicao desc", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    function listarByTipo($id_tipo)
    {
        try {
            return $this->conexao->query("select mc.*, tip.nome as tipo from maquina_costura mc join tipo tip on mc.id_tipo = tip.id where tip.id = " . $id_tipo . " order by mc.aquisicao desc", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    function listarMCByTipo($id_tipo)
    {
        try {
            return $this->conexao->query("select count(mc.id) as cont from maquina_costura mc join tipo tip on mc.id_tipo = tip.id where tip.id = " . $id_tipo . " order by mc.aquisicao desc")->fetchColumn();
        } catch (PDOException $e) {
            return false;
        }
    }

    function selecionar($id)
    {
        try {
            return $this->conexao->query("select mc.*, tip.nome as tipo from maquina_costura mc join tipo tip on mc.id_tipo = tip.id where mc.id = " . $id)->fetchObject();
        } catch (PDOException $ex) {
            return false;
        }
    }

    function selecionarByCodigo($codigo)
    {
        try {
            return $this->conexao->query("select mc.*, tip.nome as tipo from maquina_costura mc join tipo tip on mc.id_tipo = tip.id where mc.codigo = " . $codigo)->fetchObject();
        } catch (PDOException $ex) {
            return false;
        }
    }
}
