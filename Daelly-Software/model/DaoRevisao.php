<?php

class DaoRevisao
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

    function inserir(Revisao $revisao)
    {
        try {
            return $this->conexao->exec("INSERT into revisoes (data_manutencao, quilometragem, id_veiculo) values ('" . $revisao->getDataManutencao() . "', '". $revisao->getQuilometragem() ."' , '". $revisao->getIdVeiculo() ."' )");
        } catch (PDOException $ex) {
            return false;
        }
    }

    function editar(Revisao $revisao)
    {
        return $this->conexao->exec("UPDATE revisoes set data_manutencao ='" . $revisao->getDataManutencao() . "' , quilometragem = '". $revisao->getQuilometragem() ."' , id_veiculo = '". $revisao->getIdVeiculo() . "' where id=" . $revisao->getId());
    }

    function excluir($id)
    {
        try {
            return $this->conexao->exec("DELETE from revisoes where id=" . $id);
        } catch (PDOException $exc) {
            return false;
        }
    }

    function listar()
    {
        try {
            return $this->conexao->query("SELECT r.*, v.placa as veiculo FROM revisoes r join veiculos v on r.id_veiculo = v.id", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    function selecionar($id)
    {
        try {
            return $this->conexao->query("SELECT r.* from revisoes r where id =  " . $id)->fetchObject();
        } catch (PDOException $ex) {
            return false;
        }
    }

    function mesDiferenca($id, $data_manutencao){
        echo $data_manutencao;
        return $this->conexao->query("SELECT TIMESTAMPDIFF(month, (SELECT r.data_manutencao from revisoes r where r.id_veiculo = ".$id." order by r.id desc limit 1),".$data_manutencao.") as meses")->fetchColumn();
    }

    function kmDiferenca($id){
        return $this->conexao->query("SELECT r.quilometragem from revisoes r where r.id_veiculo = " . $id . " order by r.id desc limit 1")->fetchColumn();
    }
}
