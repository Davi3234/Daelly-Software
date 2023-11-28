<?php
class ControlMaquinaCostura
{
    private $maquina;
    private $daoMaquina;
    private $erros;
    private $controlMaquinaMapa;

    public function __construct()
    {
        $this->maquina = new MaquinaCostura();
        $this->daoMaquina = new DaoMaquinaCostura();
        $this->controlMaquinaMapa = new ControlMaquinaCosturaMapa();
        $this->erros = array();
    }

    public function getErros()
    {
        return $this->erros;
    }

    private function setValores($codigo = null, $modelo = null, $marca = null, $chassi = null, $aquisicao = null, $id_tipo = null, $id = null)
    {
        $this->maquina = new MaquinaCostura($codigo, $modelo, $marca, $chassi, $aquisicao, $id_tipo, $id);
    }

    private function verificarValores()
    {
        if (strlen($this->maquina->getCodigo()) == 0) {
            $this->erros[] = "Informe o código";
        } else if ($this->maquina->getCodigo() <= 0) {
            $this->erros[] = "Informe um código maior que 0";
        }
        if (strlen($this->maquina->getModelo()) == 0) {
            $this->erros[] = "Informe o modelo";
        }
        if (strlen($this->maquina->getMarca()) == 0) {
            $this->erros[] = "Informe o marca";
        }
        if (strlen($this->maquina->getChassi()) == 0) {
            $this->erros[] = "Informe o chassi";
        }
        if (strlen($this->maquina->getAquisicao()) == 0) {
            $this->erros[] = "Informe o aquisição";
        }
        if (strlen($this->maquina->getId_tipo()) == 0 || $this->maquina->getId_tipo() == 0) {
            $this->erros[] = "Informe o tipo";
        }

        return count($this->erros) == 0;
    }

    public function inserir($codigo = null, $modelo = null, $marca = null, $chassi = null, $aquisicao = null, $id_tipo = null)
    {
        $this->setValores($codigo, $modelo, $marca, $chassi, $aquisicao, $id_tipo);

        if (!$this->verificarValores()) {
            return false;
        }

        if ($this->selecionarByCodigo($codigo)) {
            $this->erros[] = "Código de máquina de costura já existe";
            return false;
        }

        if (!$this->daoMaquina->inserir($this->maquina)) {
            $this->erros[] = "Erro ao inserir o registro";
            return false;
        }

        $_id = $this->selecionarByCodigo($codigo)->id;
        if (!$this->criarMaquinaMapa($_id)) {
            $this->erros[] = "Erro ao inserir os componentes do registro";

            $this->excluir($_id);
            return false;
        }

        return true;
    }

    public function editar($codigo = null, $modelo = null, $marca = null, $chassi = null, $aquisicao = null, $id_tipo = null, $id = null)
    {
        $this->setValores($codigo, $modelo, $marca, $chassi, $aquisicao, $id_tipo, $id);
        if (!$this->verificarValores()) {
            return false;
        }

        if ($this->selecionar($id)->codigo != $codigo && $this->selecionarByCodigo($codigo)) {
            $this->erros[] = "Código de máquina de costura já existe";
            return false;
        }

        if (!$this->daoMaquina->editar($this->maquina)) {
            $this->erros[] = "Erro ao editar o registro";
            return false;
        }

        return true;
    }

    private function criarMaquinaMapa($id_maquna_costura)
    {
        return $this->controlMaquinaMapa->cadastrar($id_maquna_costura);
    }

    public function excluir($id)
    {
        if (!$this->daoMaquina->excluir($id)) {
            return false;
        }

        $this->controlMaquinaMapa->excluirByIdMaquinaCostura($id);

        return true;
    }

    public function selecionar($id)
    {
        return $this->daoMaquina->selecionar($id);
    }

    private function selecionarByCodigo($id)
    {
        return $this->daoMaquina->selecionarByCodigo($id);
    }

    public function listar()
    {
        return $this->daoMaquina->listar();
    }

    public function listarByTipo($id_tipo)
    {
        return $this->daoMaquina->listarByTipo($id_tipo);
    }

    public function listarMCByTipo($id_tipo)
    {
        return $this->daoMaquina->listarMCByTipo($id_tipo);
    }
}
