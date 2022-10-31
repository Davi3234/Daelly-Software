<?php

class DaoCliente
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

    function inserir(Cliente $cliente)
    {
        try {
            return $this->conexao->exec("insert into clientes (nome, cpf, email, telefone, data_nascimento) values ('" . $cliente->getNome() . "', '". $cliente->getCpf() ."' , '". $cliente->getEmail() ."' , '". $cliente->getTelefone() ."' , '". $cliente->getDataNascimento() ."' )");
        } catch (PDOException $ex) {
            return false;
        }
    }

    function editar(Cliente $cliente)
    {
        return $this->conexao->exec("update clientes set nome='" . $cliente->getNome() . "' , cpf = '". $cliente->getCpf() ."' , email = '". $cliente->getEmail() ."' , telefone = '". $cliente->getTelefone() . "', data_nascimento = '". $cliente->getDataNascimento() ."' where id=" . $cliente->getId());
    }

    function excluir($id)
    {
        try {
            return $this->conexao->exec("delete from clientes where id=" . $id);
        } catch (PDOException $exc) {
            return false;
        }
    }

    function listar()
    {
        try {
            return $this->conexao->query("select * from clientes", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    function selecionar($id)
    {
        try {
            return $this->conexao->query("select * from clientes where id = " . $id)->fetchObject();
        } catch (PDOException $ex) {
            return false;
        }
    }
}
