<?php

class Funcionario {
    private $id;
    private $cpf;
    private $nome;
    private $entrada;
    private $saida;
    private $id_grupo;
    
    function __construct($cpf = null, $nome = null, $entrada = null, $saida = null, $id_grupo = null, $id = null) {
        $this->id = $id;
        $this->cpf = $cpf;
        $this->nome = $nome;
        $this->entrada = $entrada;
        $this->saida = $saida;
        $this->id_grupo = $id_grupo;
    }
    
    function getId() {
        return $this->id;
    }
    
    function getIdGrupo() {
        return $this->id_grupo;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getNome() {
        return $this->nome;
    }

    function getEntrada() {
        return $this->entrada;
    }

    function getSaida() {
        return $this->saida;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEntrada($entrada) {
        $this->entrada = $entrada;
    }

    function setSaida($saida) {
        $this->saida = $saida;
    }


}
