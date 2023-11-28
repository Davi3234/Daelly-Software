<?php

class Tipo {
    private $id;
    private $nome;
    
    function __construct($nome = null, $id = null) {
        $this->id = $id;
        $this->nome = $nome;
    }
    
    function getId() {
        return $this->id;
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
