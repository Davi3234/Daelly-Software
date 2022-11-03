<?php

class MaquinaCosturaMapa {
    private $id;
    private $id_maquina_costura;
    private $posicionado;
    private $x;
    private $y;
    
    function __construct($id_maquina_costura = null, $posicionado = 0, $x = 0, $y = 0, $id = null) {
        $this->id = $id;
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
