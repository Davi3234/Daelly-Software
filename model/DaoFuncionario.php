<?php

class DaoFuncionario
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

    function inserir(Funcionario $funcionario)
    {
        try {
            return $this->conexao->exec("insert into funcionario (cpf, nome, entrada, saida, id_funcao, id_grupo) values ('" . $funcionario->getCpf() . "', '". $funcionario->getNome() ."' , '". $funcionario->getEntrada() ."' , '". $funcionario->getSaida() ."' , '". $funcionario->getIdFuncao() . "' , '". $funcionario->getIdGrupo() ."' )");
        } catch (PDOException $ex) {
            return false;
        }
    }

    function editar(Funcionario $funcionario)
    {
        return $this->conexao->exec("update funcionario set cpf='" . $funcionario->getCpf() . "' , nome = '". $funcionario->getNome() ."' , entrada = '". $funcionario->getEntrada() ."' , saida = '". $funcionario->getSaida() . "', id_funcao = '". $funcionario->getIdFuncao() . "', id_grupo = '". $funcionario->getIdGrupo() . "' where id=" . $funcionario->getId());
    }

    function excluir($id)
    {
        try {
            return $this->conexao->exec("delete from funcionario where id=" . $id);
        } catch (PDOException $exc) {
            return false;
        }
    }

    function listar()
    {
        try {
            return $this->conexao->query("select f.* , fu.nome as funcao, g.numero as grupo from funcionario f join funcao fu on fu.id = f.id_funcao join grupo g on g.id = f.id_grupo", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    function selecionar($id)
    {
        try {
            return $this->conexao->query("select * from funcionario where id = " . $id)->fetchObject();
        } catch (PDOException $ex) {
            return false;
        }
    }
}
