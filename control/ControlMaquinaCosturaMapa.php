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

    public function listarMCMapa()
    {
        return $this->daoMaquinaMapa->listarMCMapa();
    }

    public function listarMCInventario()
    {
        return $this->daoMaquinaMapa->listarMCInventario();
    }

    public function selecionar($id)
    {
        return $this->daoMaquinaMapa->selecionar($id);
    }
}
