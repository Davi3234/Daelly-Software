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
            if ($funcionario->getIdGrupo()) {
                $this->conexao->exec("insert into funcionario (cpf, nome, entrada, saida, id_grupo) values ('" . $funcionario->getCpf() . "', '" . $funcionario->getNome() . "' , '" . $funcionario->getEntrada() . "' , '" . $funcionario->getSaida() . "', '" . $funcionario->getIdGrupo() . "' )");
            } else {
                $this->conexao->exec("insert into funcionario (cpf, nome, entrada, saida) values ('" . $funcionario->getCpf() . "', '" . $funcionario->getNome() . "' , '" . $funcionario->getEntrada() . "' , '" . $funcionario->getSaida() . "')");
            }
            return true;
        } catch (PDOException $ex) {
            return false;
        }
    }

    function editar(Funcionario $funcionario)
    {
        try {
            if ($funcionario->getIdGrupo() == null) {
                $this->conexao->exec("update funcionario set cpf='" . $funcionario->getCpf() . "' , nome = '" . $funcionario->getNome() . "' , entrada = '" . $funcionario->getEntrada() . "' , saida = '" . $funcionario->getSaida() . "', id_grupo = null where id=" . $funcionario->getId());
            } else {
                $this->conexao->exec("update funcionario set cpf='" . $funcionario->getCpf() . "' , nome = '" . $funcionario->getNome() . "' , entrada = '" . $funcionario->getEntrada() . "' , saida = '" . $funcionario->getSaida() . "', id_grupo = " . $funcionario->getIdGrupo() . " where id=" . $funcionario->getId());
            }
            return true;
        } catch (PDOException $ex) {
            return false;
        }
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
            return $this->conexao->query("select f.* , (select numero from grupo where id = f.id_grupo) as grupo from funcionario f", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    function selecionar($id)
    {
        try {
            return $this->conexao->query("select f.* , (select numero from grupo where id = f.id_grupo) as grupo from funcionario f where f.id = " . $id)->fetchObject();
        } catch (PDOException $ex) {
            return false;
        }
    }

    function selecionarByCpf($cpf)
    {
        try {
            return $this->conexao->query("select f.* , (select numero from grupo where id = f.id_grupo) as grupo from funcionario f where f.cpf = '" . $cpf . "'")->fetchObject();
        } catch (PDOException $ex) {
            return false;
        }
    }
}
