<?php

class DaoAdministrador {

    private $conexao;

    function __construct() {
        try {
            include "../db-config.php";
            $this->conexao = new PDO("mysql:host=localhost;dbname=" . $GLOBALS["dbname"], $GLOBALS["user"], $GLOBALS["user"]);
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
    }

    function inserir(Administrador $administrador) {
        try {
            return $this->conexao->exec("insert into administrador (nome, email, senha, tentativas) values ('" . $administrador->getNome() . "', '" . $administrador->getEmail() . "', '" . $administrador->getSenha() . "', 0)");
        } catch (PDOException $ex) {
            return false;
        }
    }

    function editar(Administrador $administrador) {
        try {
            if($administrador->getSenha()){
                $this->conexao->exec("update administrador set nome='" . $administrador->getNome() . "', email='" . $administrador->getEmail() . "', senha='" . $administrador->getSenha() . "' where id=" . $administrador->getId());
                return true;
            }else{
                return $this->conexao->exec("update administrador set nome='" . $administrador->getNome() . "', email='" . $administrador->getEmail() . "' where id=" . $administrador->getId());
            }
            
        } catch (PDOException $ex) {
            return false;
        }
    }

    function excluir($id) {
        try {
            return $this->conexao->exec("delete from administrador where id=" . $id);
        } catch (PDOException $exc) {
            return false;
        }
    }

    function listar() {
        try {
            return $this->conexao->query("select * from administrador", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    function selecionar($id){
        try{
            return $this->conexao->query("select * from administrador where id = ".$id)->fetchObject();
        } catch (PDOException $ex) {
            return false;
        } 
    }

}
