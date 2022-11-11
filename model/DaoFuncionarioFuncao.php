<?php

class DaoFuncionarioFuncao
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

    public function iniciarTransacao() {
        return $this->conexao->beginTransaction();
    }

    public function rollback() {
        return $this->conexao->rollBack();
    }
    
    public function commit() {
        return $this->conexao->commit();
    }

    function inserir(FuncionarioFuncao $funci_funca)
    {
        try {
            return $this->conexao->exec("insert into funca_funci (id_funcionario, id_funcao) values (" . $funci_funca->getId_funcionario() . ", ".$funci_funca->getId_funcao().")");
        } catch (PDOException $ex) {
            return false;
        }
    }

    function excluir($id_funca, $id_funcionario)
    {
        try {
            return $this->conexao->exec("delete from funca_funci where id_funcao = " . $id_funca . " and id_funcionario = " . $id_funcionario);
        } catch (PDOException $exc) {
            return false;
        }
    }

    function excluirByFuncionario($id_funcionario)
    {
        try {
            return $this->conexao->exec("delete from funca_funci where id_funcionario = " . $id_funcionario);
        } catch (PDOException $exc) {
            return false;
        }
    }

    function listar()
    {
        try {
            return $this->conexao->query("select ff.* from funca_funci ff where ff.id_funcionario = 1;", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    function listarByFuncao($id)
    {
        try {
            return $this->conexao->query("select ff.* from funca_funci ff where ff.id_funcionario = 1; where funca.id = " . $id, PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    function listarByFuncionario($id)
    {
        try {
            return $this->conexao->query("select id_funcao from funca_funci where id_funcionario = " . $id);
        } catch (PDOException $e) {
            return false;
        }
    }
}
