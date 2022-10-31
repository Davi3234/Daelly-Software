<?php

class DaoVeiculo
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

    function inserir(Veiculo $veiculo)
    {
        try {
            return $this->conexao->exec("insert into veiculos (placa, modelo, ano, id_cliente, id_fabricante) values ('" . $veiculo->getPlaca() . "', '". $veiculo->getModelo() ."' , '". $veiculo->getAno() ."' , '". $veiculo->getIdCliente() ."' , '". $veiculo->getIdFabricante() ."' )");
        } catch (PDOException $ex) {
            return false;
        }
    }

    function editar(Veiculo $veiculo)
    {
        return $this->conexao->exec("update veiculos set placa='" . $veiculo->getPlaca() . "' , modelo = '". $veiculo->getModelo() ."' , ano = '". $veiculo->getAno() ."' , id_cliente = '". $veiculo->getIdCliente() . "', id_fabricante = '". $veiculo->getIdFabricante() ."' where id=" . $veiculo->getId());
    }

    function excluir($id)
    {
        try {
            return $this->conexao->exec("delete from veiculos where id=" . $id);
        } catch (PDOException $exc) {
            return false;
        }
    }

    function listar()
    {
        try {
            return $this->conexao->query("select v.*, c.nome as cliente, f.nome as fabricante FROM veiculos v join clientes c on v.id_cliente = c.id join fabricantes f on v.id_fabricante = f.id", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    function selecionar($id)
    {
        try {
            return $this->conexao->query("select v.* from veiculos v where id =  " . $id)->fetchObject();
        } catch (PDOException $ex) {
            return false;
        }
    }
}
