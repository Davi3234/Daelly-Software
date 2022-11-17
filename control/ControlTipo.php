<?php
class ControlTipo
{

    private $tipo;
    private $daoTipo;
    private $erros;

    public function __construct()
    {
        $this->tipo = new Tipo();
        $this->daoTipo = new DaoTipo();
        $this->erros = array();
    }

    public function inserir($nome)
    {
        if (strlen($nome) == 0) {
            $this->erros[] = "Informe o nome";
        } else if ($this->selecionarByNome($nome)) {
            $this->erros[] = "Nome de tipo já existe";
        }
        if (!$this->erros) {
            $this->tipo = new Tipo($nome);
            if ($this->daoTipo->inserir($this->tipo)) {
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
            $this->erros[] = "Informe o nome";
        } else if ($this->selecionar($id)->nome != $nome && $this->selecionarByNome($nome)) {
            $this->erros[] = "Nome de tipo já existe";
        }
        if (!$this->erros) {
            $this->tipo = new tipo($nome, $id);
            if ($this->daoTipo->editar($this->tipo)) {
                return true;
            }
        } else {
            $this->erros[] = "Erro ao editar o registro";
            return false;
        }
    }

    public function excluir($id)
    {
        if ($this->daoTipo->excluir($id)) {
            return true;
        } else {
            $this->erros[] = "Erro eo excluir o registro";
            return false;
        }
    }

    public function listar()
    {
        return $this->daoTipo->listar();
    }

    public function selecionar($id)
    {
        return $this->daoTipo->selecionar($id);
    }

    public function selecionarByNome($nome)
    {
        return $this->daoTipo->selecionarByNome($nome);
    }

    function getErros()
    {
        return $this->erros;
    }
}
