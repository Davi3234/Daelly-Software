<?php

class DaoMaquinaCosturaMapa
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

    function inserir(MaquinaCosturaMapa $maquina_mapa)
    {
        try {
            return $this->conexao->exec("insert into maquina_costura_mapa (posicionado, x, y, id_maquina_costura, width, height) values ('". $maquina_mapa->getPosicionado() ."' , '". $maquina_mapa->getX() ."' , '". $maquina_mapa->getY() ."', '". $maquina_mapa->getIdMaquinaCostura() ."', 100, 100)");
        } catch (PDOException $ex) {
            return false;
        }
    }

    function editar(MaquinaCosturaMapa $maquina_mapa)
    {
        return $this->conexao->exec("update maquina_costura_mapa set posicionado = '". $maquina_mapa->getPosicionado() ."' , x = '". $maquina_mapa->getX() ."' , y = '". $maquina_mapa->getY() . "' where id=" . $maquina_mapa->getId());
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
        try {
            return $this->conexao->query("select mcm.*, mc.*, tip.nome as tipo from maquina_costura_mapa mcm join maquina_costura mc on mc.id = mcm.id_maquina_costura join tipo tip on mc.id_tipo = tip.id", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    function listarMCMapa()
    {
        try {
            return $this->conexao->query("select mcm.*, mc.*, tip.nome as tipo from maquina_costura_mapa mcm join maquina_costura mc on mc.id = mcm.id_maquina_costura join tipo tip on mc.id_tipo = tip.id where mcm.posicionado = 1", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    function listarMCInventario()
    {
        try {
            return $this->conexao->query("select mcm.*, mc.*, tip.nome as tipo from maquina_costura_mapa mcm join maquina_costura mc on mc.id = mcm.id_maquina_costura join tipo tip on mc.id_tipo = tip.id where mcm.posicionado = 0", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    function selecionar($id)
    {
        try {
            return $this->conexao->query("select mcm.*, mc.*, tip.nome as tipo from maquina_costura_mapa mcm join maquina_costura mc on mc.id = mcm.id_maquina_costura join tipo tip on mc.id_tipo = tip.id where id = " . $id)->fetchObject();
        } catch (PDOException $ex) {
            return false;
        }
    }
}
