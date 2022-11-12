<?php
class ControlMapa
{
    private $daoMaquinaMapa;

    public function __construct()
    {
        $this->daoMaquinaMapa = new DaoMapa();
    }

    public function selecionar()
    {
        return $this->daoMaquinaMapa->selecionar();
    }
}
