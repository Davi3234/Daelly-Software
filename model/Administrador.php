<?php


class Administrador {
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $tentativas;
    private $ultimoAcesso;
    
    function __construct($nome = null, $email = null, $senha = null, $tentativas = null, $ultimoAcesso = null, $id = null) {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->tentativas = $tentativas;
        $this->ultimoAcesso = $ultimoAcesso;
    }
    
    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getEmail() {
        return $this->email;
    }

    function getSenha() {
        return $this->senha;
    }

    function getTentativas() {
        return $this->tentativas;
    }

    function getUltimoAcesso() {
        return $this->ultimoAcesso;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function setTentativas($tentativas) {
        $this->tentativas = $tentativas;
    }

    function setUltimoAcesso($ultimoAcesso) {
        $this->ultimoAcesso = $ultimoAcesso;
    }

}
