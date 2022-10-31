<?php
class ControlVeiculo
{

    private $veiculo;
    private $daoVeiculo;

    private $erros;

    public function __construct()
    {
        $this->veiculo = new Veiculo();
        $this->daoVeiculo = new DaoVeiculo();
        $this->erros = array();
    }

    public function inserir($placa, $modelo, $ano, $id_cliente, $id_fabricante)
    {
        if (strlen($placa) == 0) {
            $this->erros[] = "Informe a placa";
        }
        if (strlen($modelo) == 0) {
            $this->erros[] = "Informe o modelo";
        }
        if (strlen($ano) == 0) {
            $this->erros[] = "Informe o ano";
        }
        if ($id_cliente == 0) {
            $this->erros[] = "Informe o cliente";
        }
        if ($id_fabricante == 0) {
            $this->erros[] = "Informe o fabricante";
        }
        if (!$this->erros) {
            $this->veiculo = new Veiculo($placa, $modelo, $ano, $id_cliente, $id_fabricante);
            if ($this->daoVeiculo->inserir($this->veiculo)) {
                return true;
            } else {
                $this->erros[] = "Erro ao inserir o registro";
                return false;
            }
        } else {
            return false;
        }
    }

    public function editar($placa, $modelo, $ano, $id_cliente, $id_fabricante, $id)
    {
        if (strlen($placa) == 0) {
            $this->erros[] = "Informe o seu placa";
        }
        if (strlen($modelo) == 0) {
            $this->erros[] = "Informe o seu modelo";
        }
        if (strlen($ano) == 0) {
            $this->erros[] = "Informe o seu ano";
        }
        if ($id_cliente == 0) {
            $this->erros[] = "Informe o cliente";
        }
        if ($id_fabricante == 0) {
            $this->erros[] = "Informe o fabricante";
        }
        if (!$this->erros) {
            $this->veiculo = new Veiculo($placa, $modelo, $ano, $id_cliente, $id_fabricante, $id);
            if ($this->daoVeiculo->editar($this->veiculo)) {
                return true;
            }
        } else {
            $this->erros[] = "Erro ao editar o registro";
            return false;
        }
    }

    public function excluir($id)
    {
        if ($this->daoVeiculo->excluir($id)) {
            return true;
        } else {
            $this->erros[] = "Erro eo excluir o registro";
            return false;
        }
    }

    public function listar()
    {
        return $this->daoVeiculo->listar();
    }


    public function selecionar($id)
    {
        return $this->daoVeiculo->selecionar($id);
    }

    function getErros()
    {
        return $this->erros;
    }
}
