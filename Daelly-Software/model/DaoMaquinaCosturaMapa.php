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
            return $this->conexao->exec("insert into maquina_costura_mapa (codigo, posicionado, x, y, id_maquina_costura) values ('" . $maquina_mapa->getCodigo() . "', '". $maquina_mapa->getPosicionado() ."' , '". $maquina_mapa->getX() ."' , '". $maquina_mapa->getY() ."' , '". $maquina_mapa->getIdMaquinaCostura() ."' )");
        } catch (PDOException $ex) {
            return false;
        }
    }

    function editar(MaquinaCosturaMapa $maquina_mapa)
    {
        return $this->conexao->exec("update maquina_costura_mapa set codigo='" . $maquina_mapa->getCodigo() . "' , posicionado = '". $maquina_mapa->getPosicionado() ."' , x = '". $maquina_mapa->getX() ."' , y = '". $maquina_mapa->getY() . "', id_maquina_costura = '". $maquina_mapa->getIdMaquinaCostura() . "' where id=" . $maquina_mapa->getId());
    }

    function excluir($id)
    {
        try {
            return $this->conexao->exec("delete from maquina_costura_mapa where id=" . $id);
        } catch (PDOException $exc) {
            return false;
        }
    }

    function listar()
    {
        try {
            return $this->conexao->query("select map.* , maq.codigo as maquina_costura from maquina_costura_mapa map join maquina_costura maq on maq.id = map.id_maquina_costura", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    function selecionar($id)
    {
        try {
            return $this->conexao->query("select * from maquina_costura_mapa where id = " . $id)->fetchObject();
        } catch (PDOException $ex) {
            return false;
        }
    }
}
