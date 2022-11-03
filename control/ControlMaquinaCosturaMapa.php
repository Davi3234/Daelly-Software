<?php
class ControlMaquinaCosturaMapa
{

    private $maquina_mapa;
    private $daoMaquinaMapa;

    public function __construct()
    {
        $this->maquina_mapa = new MaquinaCosturaMapa();
        $this->daoMaquinaMapa = new DaoMaquinaCosturaMapa();
    }

    private function setValores($id_maquina_costura = null, $posicionado = 0, $x = 0, $y = 0, $id = null) {
        $this->maquina_mapa = new MaquinaCosturaMapa($posicionado, $x, $y, $id_maquina_costura, $id);
    }

    public function cadastrar($id_maquina_costura) {
        $this->setValores($id_maquina_costura);

        return $this->daoMaquinaMapa->inserir($this->maquina_mapa);
    }

    public function editar($id, $id_maquina_costura = null, $posicionado = 0, $x = 0, $y = 0) {
        $this->setValores($id_maquina_costura, $posicionado, $x, $y, $id);

        return $this->daoMaquinaMapa->editar($this->maquina_mapa);
    }

    public function excluir($id) {
        return $this->daoMaquinaMapa->excluir($id);
    }

    public function selecionar($id)
    {
        return $this->daoMaquinaMapa->selecionar($id);
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
}
