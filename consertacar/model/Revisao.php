<?php

class Revisao {
    private $id;
    private $data_manutencao;
    private $quilometragem;
    private $id_veiculo;
    
    function __construct($data_manutencao = null, $quilometragem = null, $id_veiculo = null, $id = null) {
        $this->data_manutencao = $data_manutencao;
        $this->quilometragem = $quilometragem;
        $this->id_veiculo = $id_veiculo;
        $this->id = $id;
    }
    
    function getId() {
        return $this->id;
    }

    function getDataManutencao() {
        return $this->data_manutencao;
    }

    function getQuilometragem() {
        return $this->quilometragem;
    }

    function getIdVeiculo() {
        return $this->id_veiculo;
    }

    function setIdVeiculo($id_veiculo) {
        $this->id_fabricante = $id_veiculo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDataManutencao($data_manutencao) {
        $this->data_manutencao = $data_manutencao;
    }

    function setQuilometragem($quilometragem) {
        $this->quilometragem = $quilometragem;
    }

}
