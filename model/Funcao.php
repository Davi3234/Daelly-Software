<?php

class Funcao {
    private $id;
    private $nome;
    private $id_tipo;
    
    function __construct($nome = null, $id_tipo = null, $id = null) {
        $this->id = $id;
        $this->nome = $nome;
        $this->id_tipo = $id_tipo;
    }
    
    function getId() {
        return $this->id;
    }

    function getIdTipo() {
        return $this->id_tipo;
    }

    function getNome() {
        return $this->nome;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }



}
