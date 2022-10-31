<?php

class Grupo {
    private $id;
    private $nome;
    private $cpf;
    private $email;
    private $telefone;
    private $data_nascimento;
    
    function __construct($nome = null, $cpf = null, $email = null , $telefone = null, $data_nascimento = null, $id = null) {
        $this->id = $id;
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->email = $email;
        $this->telefone = $telefone;
        $this->data_nascimento = $data_nascimento;
    }
    
    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getEmail() {
        return $this->email;
    }
    
    function getTelefone() {
        return $this->telefone;
    }

    function getDataNascimento() {
        return $this->data_nascimento;
    }

    function setDataNascimento($data_nascimento) {
        $this->data_nascimento = $data_nascimento;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

}
