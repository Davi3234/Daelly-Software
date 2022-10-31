<?php

class Veiculo {
    private $id;
    private $placa;
    private $modelo;
    private $ano;
    private $id_cliente;
    private $id_fabricante;
    
    function __construct($placa = null, $modelo = null, $ano = null , $id_cliente = null, $id_fabricante = null, $id = null) {
        $this->id = $id;
        $this->placa = $placa;
        $this->modelo = $modelo;
        $this->ano = $ano;
        $this->id_cliente = $id_cliente;
        $this->id_fabricante = $id_fabricante;
    }
    
    function getId() {
        return $this->id;
    }

    function getPlaca() {
        return $this->placa;
    }

    function getModelo() {
        return $this->modelo;
    }

    function getAno() {
        return $this->ano;
    }
    
    function getIdCliente() {
        return $this->id_cliente;
    }

    function getIdFabricante() {
        return $this->id_fabricante;
    }

    function setIdFabricante($id_fabricante) {
        $this->id_fabricante = $id_fabricante;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setPlaca($placa) {
        $this->placa = $placa;
    }

    function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    function setAno($ano) {
        $this->ano = $ano;
    }

    function setIdCliente($id_cliente) {
        $this->id_cliente = $id_cliente;
    }

}
