<?php
class ControlFabricante
{

    private $fabricante;
    private $daoFabricante;
    private $erros;

    public function __construct()
    {
        $this->fabricante = new Fabricante();
        $this->daoFabricante = new DaoFabricante();
        $this->erros = array();
    }

    public function inserir($nome)
    {
        if (strlen($nome) == 0) {
            $this->erros[] = "Informe o seu nome";
        }
        if (!$this->erros) {
            $this->fabricante = new Fabricante($nome);
            if ($this->daoFabricante->inserir($this->fabricante)) {
                return true;
            } else {
                $this->erros[] = "Erro ao inserir o registro";
                return false;
            }
        } else {
            return false;
        }
    }

    public function editar($nome, $id)
    {
        if (strlen($nome) == 0) {
            $this->erros[] = "Informe o seu nome";
        }
        if (!$this->erros) {
            $this->fabricante = new Fabricante($nome, $id);
            if ($this->daoFabricante->editar($this->fabricante)) {
                return true;
            }
        } else {
            $this->erros[] = "Erro ao editar o registro";
            return false;
        }
    }

    public function excluir($id)
    {
        if ($this->daoFabricante->excluir($id)) {
            return true;
        } else {
            $this->erros[] = "Erro eo excluir o registro";
            return false;
        }
    }

    public function listar()
    {
        return $this->daoFabricante->listar();
    }

    public function selecionar($id)
    {
        return $this->daoFabricante->selecionar($id);
    }

    function getErros()
    {
        return $this->erros;
    }
}
