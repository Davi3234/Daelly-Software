<?php

class DaoFuncionario
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

    function desvincularGrupo($id)
    {
        try {
            $this->conexao->exec("update funcionario set id_grupo = null where id_grupo = " . $id);
            return true;
        } catch (PDOException $ex) {
            return false;
        }
    }

    function desvincularFuncionarioGrupo($id)
    {
        try {
            $this->conexao->exec("update funcionario set id_grupo = null where id = " . $id);
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
            return $this->conexao->query("select f.* , (select numero from grupo where id = f.id_grupo) as grupo from funcionario f order by f.entrada asc", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    function listarByFuncao($id_funcao)
    {
        try {
            return $this->conexao->query("select funci.*, (select numero from grupo where id = funci.id_grupo) as grupo from funcionario funci join funca_funci ff on ff.id_funcionario = funci.id join funcao funca on funca.id = ff.id_funcao where funca.id = " . $id_funcao . "  order by funci.entrada asc", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    function listarByGrupo($id_grupo)
    {
        try {
            return $this->conexao->query("select funci.* from funcionario funci join grupo gru on gru.id = funci.id_grupo where gru.id = " . $id_grupo . " order by funci.entrada asc", PDO::FETCH_OBJ);
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
