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

    public function inserir($nome, $id_tipo)
    {
        if (strlen($nome) == 0) {
            $this->erros[] = "Informe o nome";
        } else if ($this->selecionarByNome($nome)) {
            $this->erros[] = "Nome de compressor já existe";
        }
        if (strlen($id_tipo) == 0) {
            $this->erros[] = "Informe o tipo";
        } else if ($id_tipo == 0) {
            $id_tipo = null;
        }
        if (!$this->erros) {
            $this->funcao = new Funcao($nome, $id_tipo);
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

    public function editar($nome, $id_tipo, $id)
    {
        if (strlen($nome) == 0) {
            $this->erros[] = "Informe o nome";
        } else if ($this->selecionar($id)->nome != $nome && $this->selecionarByNome($nome)) {
            $this->erros[] = "Nome de compressor já existe";
        }
        if (strlen($id_tipo) == 0) {
            $this->erros[] = "Informe o tipo";
        } else if ($id_tipo == 0) {
            $id_tipo = null;
        }
        if (!$this->erros) {
            $this->funcao = new Funcao($nome, $id_tipo, $id);
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

    public function desvincularByTipo($id)
    {
        if ($this->daoFuncao->desvincularByTipo($id)) {
            return true;
        } else {
            $this->erros[] = "Erro ao desvincular as funções do tipo";
            return false;
        }
    }

    public function desvincularTipo($id)
    {
        if ($this->daoFuncao->desvincularTipo($id)) {
            return true;
        } else {
            $this->erros[] = "Erro ao desvincular a função do tipo";
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

    public function selecionarByNome($nome)
    {
        return $this->daoFuncao->selecionarByNome($nome);
    }

    function getErros()
    {
        return $this->erros;
    }
}
