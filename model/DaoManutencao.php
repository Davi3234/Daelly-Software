<?php

class DaoManutencao
{

    private $conexao;

    function __construct()
    {
        try {
            include "../config/db-config.php";
            $this->conexao = new PDO("mysql:host=localhost;dbname=" . $GLOBALS["dbname"], $GLOBALS["user"], $GLOBALS["pass"]);
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
    }

    function inserir(Manutencao $manutencao)
    {
        try {
            return $this->conexao->exec("insert into manutencao (descricao, data_manutencao, id_maquina, id_compressor) values ('" . $manutencao->getDescricao() . "','" . $manutencao->getDataManutencao() . $manutencao->getIdCompresor() . "','" . $manutencao->getIdMaquina() . "' )");
        } catch (PDOException $ex) {
            return false;
        }
    }

    function editar(Manutencao $manutencao)
    {
        return $this->conexao->exec("update manutencao set descricao='" . $manutencao->getDescricao() . "'data_manutencao ='" . $manutencao->getDataManutencao() . "'where id=" . $manutencao->getId());
    }

    function excluir($id)
    {
        try {
            return $this->conexao->exec("delete from manutencao where id=" . $id);
        } catch (PDOException $exc) {
            return false;
        }
    }

    function listar()
    {
        try {
            return $this->conexao->query("select m.*, maq.codigo as maquina, c.codigo as compressor from manutencao m join maquina maq on maq.id = m.id_maquina join compressor c on c.id = m.id_compressor", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    function selecionar($id)
    {
        try {
            return $this->conexao->query("select * from manutencao where id = " . $id)->fetchObject();
        } catch (PDOException $ex) {
            return false;
        }
    }
}
