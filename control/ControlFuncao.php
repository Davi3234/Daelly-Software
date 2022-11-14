<?php
class ControlFuncao
{

    private $funcao;
    private $daoFuncao;
    private $erros;

    public function __construct()
    {
        $this->funcao = new Funcao();
        $this->daoFuncao = new DaoFuncao();
        $this->erros = array();
    }

    public function inserir($nome, $id_tipo = null)
    {
        if (strlen($nome) == 0) {
            $this->erros[] = "Informe o nome";
        }
        if (strlen($id_tipo) == 0) {
            $this->erros[] = "Informe o tipo";
        } else if ($id_tipo == 0) {
            $id_tipo = null;
        }
        if (!$this->erros) {
            $this->funcao = new Funcao($nome, $id_tipo == 0 ? null : $id_tipo);
            if ($this->daoFuncao->inserir($this->funcao)) {
                return true;
            } else {
                $this->erros[] = "Erro ao inserir o registro";
                return false;
            }
        } else {
            return false;
        }
    }

    public function editar($nome, $id_tipo = null, $id)
    {
        if (strlen($nome) == 0) {
            $this->erros[] = "Informe o nome";
        }
        if (!$this->erros) {
            $this->funcao = new Funcao($nome, $id_tipo == 0 ? null : $id_tipo, $id);
            if ($this->daoFuncao->editar($this->funcao)) {
                return true;
            }
        } else {
            $this->erros[] = "Erro ao editar o registro";
            return false;
        }
    }

    public function excluir($id)
    {
        if ($this->daoFuncao->excluir($id)) {
            return true;
        } else {
            $this->erros[] = "Erro eo excluir o registro";
            return false;
        }
    }

    public function listar()
    {
        return $this->daoFuncao->listar();
    }

    public function listarByTipo($id_tipo)
    {
        return $this->daoFuncao->listarByTipo($id_tipo);
    }

    public function selecionar($id)
    {
        return $this->daoFuncao->selecionar($id);
    }

    function getErros()
    {
        return $this->erros;
    }
}
