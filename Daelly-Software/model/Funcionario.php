<?php

class Grupo {
    private $id;
    private $cpf;
    private $nome;
    private $entrada;
    private $saida;
    
    function __construct($cpf = null, $nome = null, $entrada = null, $saida = null, $id = null) {
        $this->id = $id;
        $this->cpf = $cpf;
        $this->nome = $nome;
        $this->entrada = $entrada;
        $this->saida = $saida;
    }
    
    function getId() {
        return $this->id;
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



}
