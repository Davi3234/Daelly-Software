<?php

class Grupo {
    private $id;
    private $numero;
    
    function __construct($numero = null, $id = null) {
        $this->id = $id;
        $this->numero = $numero;
    }
    
    function getId() {
        return $this->id;
    }

    function getNumero() {
        return $this->numero;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }



}
