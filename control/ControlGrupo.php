<?php
class ControlGrupo
{

    private $grupo;
    private $daoGrupo;
    private $erros;

    public function __construct()
    {
        $this->grupo = new Grupo();
        $this->daoGrupo = new DaoGrupo();
        $this->erros = array();
    }

    public function inserir($numero)
    {
        if (strlen($numero) == 0) {
            $this->erros[] = "Informe o número";
        } else if ($this->selecionarByNumero($numero)) {
            $this->erros[] = "Número de grupo já cadastrado";
        }
        if (!$this->erros) {
            $this->grupo = new Grupo($numero);
            if ($this->daoGrupo->inserir($this->grupo)) {
                return true;
            } else {
                $this->erros[] = "Erro ao inserir o registro";
                return false;
            }
        } else {
            return false;
        }
    }

    public function editar($numero, $id)
    {
        if (strlen($numero) == 0) {
            $this->erros[] = "Informe o número";
        } else if ($this->selecionar($id)->numero != $numero && $this->selecionarByNumero($numero)) {
            $this->erros[] = "Número de grupo já cadastrado";
        }
        if (!$this->erros) {
            $this->grupo = new Grupo($numero, $id);
            if ($this->daoGrupo->editar($this->grupo)) {
                return true;
            }
        } else {
            $this->erros[] = "Erro ao editar o registro";
            return false;
        }
    }

    public function excluir($id)
    {
        if ($this->daoGrupo->excluir($id)) {
            return true;
        } else {
            $this->erros[] = "Erro eo excluir o registro";
            return false;
        }
    }

    public function listar()
    {
        return $this->daoGrupo->listar();
    }

    public function selecionar($id)
    {
        return $this->daoGrupo->selecionar($id);
    }

    public function selecionarByNumero($id)
    {
        return $this->daoGrupo->selecionarByNumero($id);
    }

    function getErros()
    {
        return $this->erros;
    }
}
