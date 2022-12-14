<?php

class Manutencao {
    private $id;
    private $descricao;
    private $id_maquina_costura;
    private $id_compressor;
    private $data_manutencao;
    
    function __construct($descricao = null, $data_manutencao = null, $id_maquina_costura = null, $id_compressor = null,  $id = null) {
        $this->id = $id;
        $this->descricao = $descricao;
        $this->data_manutencao = $data_manutencao;
        $this->id_maquina_costura = $id_maquina_costura;
        $this->id_compressor = $id_compressor;
    }
    
    function getId() {
        return $this->id;
    }

    function getIdMaquina() {
        return $this->id_maquina_costura;
    }

    function getDataManutencao() {
        return $this->data_manutencao;
    }

    function getIdCompresor() {
        return $this->id_compressor;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setDataManutencao($data_manutencao) {
        $this->data_manutencao = $data_manutencao;
    }
}
