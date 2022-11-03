<?php

class MaquinaCostura
{
    private $id;
    private $codigo;
    private $modelo;
    private $marca;
    private $chassi;
    private $aquisicao;
    private $id_tipo;

    function __construct($codigo = null, $modelo = null, $marca = null, $chassi = null, $aquisicao = null, $id_tipo = null, $id = null)
    {
        $this->id = $id;
        $this->codigo = $codigo;
        $this->modelo = $modelo;
        $this->marca = $marca;
        $this->chassi = $chassi;
        $this->aquisicao = $aquisicao;
        $this->id_tipo = $id_tipo;
    }

    function getId()
    {
        return $this->id;
    }

    function getIdTipo()
    {
        return $this->id_tipo;
    }

    function getMarca()
    {
        return $this->marca;
    }

    function getCodigo()
    {
        return $this->codigo;
    }

    function getModelo()
    {
        return $this->modelo;
    }

    function getChassi()
    {
        return $this->chassi;
    }

    function getAquisicao()
    {
        return $this->aquisicao;
    }


    function setId($id)
    {
        $this->id = $id;
    }

    function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    function setMarca($marca)
    {
        $this->marca = $marca;
    }

    function setModelo($modelo)
    {
        $this->modelo = $modelo;
    }

    function setChassi($chassi)
    {
        $this->chassi = $chassi;
    }

    function setAquisicao($aquisicao)
    {
        $this->aquisicao = $aquisicao;
    }
}
