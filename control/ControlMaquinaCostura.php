<?php
class ControlMaquinaCostura
{

    private $maquinaCostura;
    private $daoMaquinaCostura;
    private $erros;

    public function __construct()
    {
        $this->maquinaCostura = new MaquinaCostura();
        $this->daoMaquinaCostura = new DaoMaquinaCostura();
        $this->erros = array();
    }

    public function inserir($codigo, $modelo, $marca, $chassi, $aquisicao, $id_tipo)
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
        if (strlen($chassi) == 0) {
            $this->erros[] = "Informe o chassi";
        }
        if (strlen($aquisicao) == 0) {
            $this->erros[] = "Informe a data de aquisição";
        }
        if (strlen($id_tipo) == 0) {
            $this->erros[] = "Informe o tipo";
        }
        if (!$this->erros) {
            $this->maquinaCostura = new MaquinaCostura($codigo, $modelo, $marca, $chassi, $aquisicao, $id_tipo);
            if ($this->daoMaquinaCostura->inserir($this->maquinaCostura)) {
                return true;
            } else {
                $this->erros[] = "Erro ao inserir o registro";
                return false;
            }
        } else {
            return false;
        }
    }

    public function editar($codigo, $modelo, $marca, $chassi, $aquisicao, $id_tipo, $id)
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
        if (strlen($chassi) == 0) {
            $this->erros[] = "Informe o chassi";
        }
        if (strlen($aquisicao) == 0) {
            $this->erros[] = "Informe a data de aquisição";
        }
        if (strlen($id_tipo) == 0) {
            $this->erros[] = "Informe o tipo";
        }
        if (!$this->erros) {
            $this->maquinaCostura = new MaquinaCostura($codigo, $modelo, $marca, $chassi, $aquisicao, $id_tipo, $id);
            if ($this->daoMaquinaCostura->editar($this->maquinaCostura)) {
                return true;
            }
        } else {
            $this->erros[] = "Erro ao editar o registro";
            return false;
        }
    }

    public function excluir($id)
    {
        if ($this->daoMaquinaCostura->excluir($id)) {
            return true;
        } else {
            $this->erros[] = "Erro eo excluir o registro";
            return false;
        }
    }

    public function listar()
    {
        return $this->daoMaquinaCostura->listar();
    }

    public function selecionar($id)
    {
        return $this->daoMaquinaCostura->selecionar($id);
    }

    function getErros()
    {
        return $this->erros;
    }
}
