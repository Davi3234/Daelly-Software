<?php

class DaoFuncao
{

    private $conexao;

    function __construct()
    {
        try {
            include "../assets/db-config.php";
            $this->conexao = new PDO("mysql:host=localhost;dbname=" . $GLOBALS["dbname"], $GLOBALS["user"], $GLOBALS["pass"]);
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
    }

    function inserir(Funcao $funcao)
    {
        try {
            if ($funcao->getIdTipo()) {
                return $this->conexao->exec("insert into funcao (nome, id_tipo) values ('" . $funcao->getNome() . "', '" . $funcao->getIdTipo() . "' )");
            }
            return $this->conexao->exec("insert into funcao (nome) values ('" . $funcao->getNome() . "')");
        } catch (PDOException $ex) {
            return false;
        }
    }

    function editar(Funcao $funcao)
    {
        try {
            if ($funcao->getIdTipo()) {
                $this->conexao->exec("update funcao set nome='" . $funcao->getNome() . "' id_tipo = '" . $funcao->getIdTipo() . "'where id=" . $funcao->getId());
            } else {
                $this->conexao->exec("update funcao set nome='" . $funcao->getNome() . "' where id=" . $funcao->getId());
            }
            return true;
        } catch (PDOException) {
            return false;
        }
    }

    function excluir($id)
    {
        try {
            $this->conexao->exec("delete from funcao where id=" . $id);
            return true;
        } catch (PDOException $exc) {
            return false;
        }
    }

    function listar()
    {
        try {
            return $this->conexao->query("select f.*, t.nome as tipo from funcao f join tipo t on t.id = f.id_tipo", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    function listarByTipo($id_tipo)
    {
        try {
            return $this->conexao->query("select f.* from funcao f join tipo t on t.id = f.id_tipo where t.id = " . $id_tipo, PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    function selecionar($id)
    {
        try {
            return $this->conexao->query("select * from funcao where id = " . $id)->fetchObject();
        } catch (PDOException $ex) {
            return false;
        }
    }
}
