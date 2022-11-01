<?php
class ControlMaquinaCosturaMapa
{

    private $maquina_mapa;
    private $daoMaquinaMapa;

    public function __construct()
    {
        $this->maquina_mapa = new MaquinaCosturaMapa();
        $this->daoMaquinaMapa = new DaoMaquinaCosturaMapa();
        $this->erros = array();
    }

    public function listar()
    {
        return $this->daoMaquinaMapa->listar();
    }

    public function selecionar($id)
    {
        return $this->daoMaquinaMapa->selecionar($id);
    }
}
