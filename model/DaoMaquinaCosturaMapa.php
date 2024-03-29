<?php

class DaoMaquinaCosturaMapa
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

    function inserir(MaquinaCosturaMapa $maquina_mapa)
    {
        try {
            return $this->conexao->exec("insert into maquina_costura_mapa (posicionado, x, y, id_maquina_costura) values (". $maquina_mapa->getPosicionado() .", ". $maquina_mapa->getX() .", ". $maquina_mapa->getY() .", ". $maquina_mapa->getIdMaquinaCostura() .")");
        } catch (PDOException $ex) {
            return false;
        }
    }

    function editar(MaquinaCosturaMapa $maquina_mapa)
    {
        $this->conexao->exec("update maquina_costura_mapa set posicionado = ". $maquina_mapa->getPosicionado() .", x = ". $maquina_mapa->getX() .", y = ". $maquina_mapa->getY() . " where id = " . $maquina_mapa->getId());
        return true;
    }

    function excluir($id)
    {
        try {
            return $this->conexao->exec("delete from maquina_costura_mapa where id=" . $id);
        } catch (PDOException $exc) {
            return false;
        }
    }

    function excluirByIdMaquinaCostura($id)
    {
        try {
            return $this->conexao->exec("delete from maquina_costura_mapa where id_maquina_costura=" . $id);
        } catch (PDOException $exc) {
            return false;
        }
    }

    function listar()
    {
        try { // select mcm.id, mcm.id_maquina_costura, mcm.posicionado, mcm.x, mcm.y, mc.codigo, mc.modelo, mc.marca, mc.chassi, mc.aquisicao, tip.nome as tipo, funci.nome as funcionario from maquina_costura_mapa mcm join maquina_costura mc on mc.id = mcm.id_maquina_costura join tipo tip on mc.id_tipo = tip.id join funcao funca on funca.id_tipo = tip.id join funca_funci ff on ff.id_funcao = funca.id join funcionario funci on funci.id = ff.id_funcionario
            return $this->conexao->query("select mcm.id, mcm.id_maquina_costura, mcm.posicionado, mcm.x, mcm.y, mc.codigo, mc.modelo, mc.marca, mc.chassi, mc.aquisicao, tip.nome as tipo from maquina_costura_mapa mcm join maquina_costura mc on mc.id = mcm.id_maquina_costura join tipo tip on mc.id_tipo = tip.id", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    function listarMCMapa()
    {
        try {
            return $this->conexao->query("select mcm.id, mcm.id_maquina_costura, mcm.posicionado, mcm.x, mcm.y, mc.codigo, mc.modelo, mc.marca, mc.chassi, mc.aquisicao, tip.nome as tipo from maquina_costura_mapa mcm join maquina_costura mc on mc.id = mcm.id_maquina_costura join tipo tip on mc.id_tipo = tip.id where mcm.posicionado = 1", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    function listarMCInventario()
    {
        try {
            return $this->conexao->query("select mcm.id, mcm.id_maquina_costura, mcm.posicionado, mcm.x, mcm.y, mc.codigo, mc.modelo, mc.marca, mc.chassi, mc.aquisicao, tip.nome as tipo from maquina_costura_mapa mcm join maquina_costura mc on mc.id = mcm.id_maquina_costura join tipo tip on mc.id_tipo = tip.id where mcm.posicionado = 0", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    function selecionar($id)
    {
        try {
            return $this->conexao->query("select mcm.id, mcm.id_maquina_costura, mcm.posicionado, mcm.x, mcm.y, mc.codigo, mc.modelo, mc.marca, mc.chassi, mc.aquisicao, tip.nome as tipo from maquina_costura_mapa mcm join maquina_costura mc on mc.id = mcm.id_maquina_costura join tipo tip on mc.id_tipo = tip.id where id = " . $id)->fetchObject();
        } catch (PDOException $ex) {
            return false;
        }
    }
}
