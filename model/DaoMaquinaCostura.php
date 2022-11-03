<?php

class DaoMaquinaCostura
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

    function inserir(MaquinaCostura $maquinaCostura)
    {
        try {
            return $this->conexao->exec("insert into maquina_costura (codigo, modelo, marca, chassi, aquisicao, id_tipo) values ('" . $maquinaCostura->getCodigo() . "', '".$maquinaCostura->getModelo(). "', '".$maquinaCostura->getMarca(). "', '".$maquinaCostura->getChassi(). "', '".$maquinaCostura->getAquisicao(). "', '".$maquinaCostura->getIdTipo()."' )");
        } catch (PDOException $ex) {
            return false;
        }
    }

    function editar(MaquinaCostura $maquinaCostura)
    {
        return $this->conexao->exec("update maquina_costura set codigo='" . $maquinaCostura->getCodigo() . "' modelo = '".$maquinaCostura->getModelo(). "' modelo = '".$maquinaCostura->getMarca(). "' modelo = '".$maquinaCostura->getChassi(). "' modelo = '".$maquinaCostura->getAquisicao(). "' modelo = '".$maquinaCostura->getIdTipo()."'where id=".$maquinaCostura->getId());
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
            return $this->conexao->query("select m.*, t.nome as tipo from maquina_costura m join tipo t on t.id = m.id_tipo", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    function selecionar($id)
    {
        try {
            return $this->conexao->query("select * from maquina_costura where id = " . $id)->fetchObject();
        } catch (PDOException $ex) {
            return false;
        }
    }
}
