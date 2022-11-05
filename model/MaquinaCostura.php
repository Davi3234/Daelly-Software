<?php

class MaquinaCostura {
    private $id;
    private $id_tipo;
    private $codigo;
    private $modelo;
    private $marca;
    private $chassi;
    private $aquisicao;

    public function __construct($codigo = null, $modelo = null, $marca = null, $chassi= null, $aquisicao= null, $id_tipo = null, $id = null) {
        $this->id = $id;
        $this->id_tipo = $id_tipo;
        $this->codigo = $codigo;
        $this->modelo = $modelo;
        $this->marca = $marca;
        $this->chassi = $chassi;
        $this->aquisicao = $aquisicao;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId_tipo() {
        return $this->id_tipo;
    }

    public function setId_tipo($id_tipo) {
        $this->id_tipo = $id_tipo;
    }
    
    public function getCodigo() {
        return $this->codigo;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }
    
    public function getModelo() {
        return $this->modelo;
    }

    public function setModelo($modelo) {
        $this->modelo = $modelo;
    }
    
    public function getMarca() {
        return $this->marca;
    }

    public function setMarca($marca) {
        $this->marca = $marca;
    }
    
    public function getChassi() {
        return $this->chassi;
    }

    public function setChassi($chassi) {
        $this->chassi = $chassi;
    }
    
    public function getAquisicao() {
        return $this->aquisicao;
    }

    public function setAquisicao($aquisicao) {
        $this->aquisicao = $aquisicao;
    }
}
