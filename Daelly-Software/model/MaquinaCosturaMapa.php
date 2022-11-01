<?php

class MaquinaCosturaMapa {
    private $id;
    private $id_maquina_costura;
    private $codigo;
    private $posicionado;
    private $x;
    private $y;
    
    function __construct($codigo = null, $posicionado = null, $x = null, $y = null, $id_maquina_costura = null, $id = null) {
        $this->id = $id;
        $this->codigo = $codigo;
        $this->posicionado = $posicionado;
        $this->x = $x;
        $this->y = $y;
        $this->id_maquina_costura = $id_maquina_costura;
    }
    
    function getId() {
        return $this->id;
    }

    function getIdMaquinaCostura() {
        return $this->id_maquina_costura;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getPosicionado() {
        return $this->posicionado;
    }

    function getX() {
        return $this->x;
    }

    function getY() {
        return $this->y;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setPosicionado($posicionado) {
        $this->posicionado = $posicionado;
    }

    function setX($x) {
        $this->x = $x;
    }

    function setY($y) {
        $this->y = $y;
    }



}
