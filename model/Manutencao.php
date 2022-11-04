<?php

class Compressor {
    private $id;
    private $descricao;
    private $data_manutencao;
    private $id_maquina_costura;
    private $id_compressor;
    
    function __construct($descricao = null, $data_manutencao = null, $id_maquina_costura = null, $id_compressor= null, $id = null) {
        $this->id = $id;
        $this->descricao = $descricao;
        $this->data_manutencao = $data_manutencao;
        $this->id_maquina_costura = $id_maquina_costura;
        $this->id_compressor = $id_compressor;
    }
    
    function getId() {
        return $this->id;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getDataManutencao() {
        return $this->data_manutencao;
    }

    function getIdMaquinaCostura() {
        return $this->id_maquinacostura;
    }

    function getIdCompressor() {
        return $this->id_compressor;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDataManutencao($data_manutencao) {
        $this->data_manutencao = $data_manutencao;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setIdMaquinaCostura($id_maquinacostura) {
        $this->id_maquinacostura = $id_maquinacostura;
    }



}
