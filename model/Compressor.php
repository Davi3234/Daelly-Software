<?php

class Compressor {
    private $id;
    private $codigo;
    private $marca;
    private $modelo;
    
    function __construct($codigo = null, $marca = null, $modelo = null, $id = null) {
        $this->id = $id;
        $this->codigo = $codigo;
        $this->marca = $marca;
        $this->modelo = $modelo;
    }
    
    function getId() {
        return $this->id;
    }

    function getMarca() {
        return $this->marca;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getModelo() {
        return $this->modelo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setMarca($marca) {
        $this->marca = $marca;
    }

    function setModelo($modelo) {
        $this->modelo = $modelo;
    }



}
