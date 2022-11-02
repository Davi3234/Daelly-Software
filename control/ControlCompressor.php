<?php
class ControlCompressor
{

    private $compressor;
    private $daoCompressor;
    private $erros;

    public function __construct()
    {
        $this->compressor = new Compressor();
        $this->daoCompressor = new DaoCompressor();
        $this->erros = array();
    }

    public function inserir($codigo, $marca, $modelo)
    {
        if (strlen($codigo) == 0) {
            $this->erros[] = "Informe o código";
        }
        if (strlen($marca) == 0) {
            $this->erros[] = "Informe a marca";
        }
        if (strlen($modelo) == 0) {
            $this->erros[] = "Informe o modelo";
        }
        if (!$this->erros) {
            $this->compressor = new Compressor($codigo, $marca, $modelo);
            if ($this->daoCompressor->inserir($this->compressor)) {
                return true;
            } else {
                $this->erros[] = "Erro ao inserir o registro";
                return false;
            }
        } else {
            return false;
        }
    }

    public function editar($codigo, $marca, $modelo, $id)
    {
        if (strlen($codigo) == 0) {
            $this->erros[] = "Informe o código";
        }
        if (strlen($marca) == 0) {
            $this->erros[] = "Informe a marca";
        }
        if (strlen($modelo) == 0) {
            $this->erros[] = "Informe o modelo";
        }
        if (!$this->erros) {
            $this->compressor = new Compressor($codigo, $marca, $modelo, $id);
            if ($this->daoCompressor->editar($this->compressor)) {
                return true;
            }
        } else {
            $this->erros[] = "Erro ao editar o registro";
            return false;
        }
    }

    public function excluir($id)
    {
        if ($this->daoCompressor->excluir($id)) {
            return true;
        } else {
            $this->erros[] = "Erro eo excluir o registro";
            return false;
        }
    }

    public function listar()
    {
        return $this->daoCompressor->listar();
    }

    public function selecionar($id)
    {
        return $this->daoCompressor->selecionar($id);
    }

    function getErros()
    {
        return $this->erros;
    }
}
