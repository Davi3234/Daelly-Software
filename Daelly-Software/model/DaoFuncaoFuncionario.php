<?php

class DaoFuncaoFuncionario
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

    function inserir(Funcao $funcao)
    {
        try {
            return $this->conexao->exec("insert into funcao (nome, id_tipo) values ('" . $funcao->getNome() . "', '".$funcao->getIdTipo()."' )");
        } catch (PDOException $ex) {
            return false;
        }
    }

}
