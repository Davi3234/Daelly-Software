<?php
class ControlFuncionario
{

    private $funcionario;
    private $daoFuncionario;
    private $erros;

    public function __construct()
    {
        $this->funcionario = new Funcionario();
        $this->daoFuncionario = new DaoFuncionario();
        $this->erros = array();
    }

    public function inserir($cpf, $nome, $entrada, $saida, $id_funcao, $id_grupo)
    {
        if (strlen($cpf) == 0) {
            $this->erros[] = "Informe o CPF";
        }
        if (strlen($nome) == 0) {
            $this->erros[] = "Informe o nome";
        }
        if (strlen($entrada) == 0) {
            $this->erros[] = "Informe a data de entrada";
        }
        if (strlen($id_grupo) == 0) {
            $this->erros[] = "Informe o grupo";
        }
        if (!$this->erros) {
            $this->funcionario = new Funcionario($cpf, $nome, $entrada, $saida, $id_funcao, $id_grupo);
            if ($this->daoFuncionario->inserir($this->funcionario)) {
                return true;
            } else {
                $this->erros[] = "Erro ao inserir o registro";
                return false;
            }
        } else {
            return false;
        }
    }

    public function editar($cpf, $nome, $entrada, $saida, $id_funcao, $id_grupo, $id)
    {
        if (strlen($cpf) == 0) {
            $this->erros[] = "Informe o CPF";
        }
        if (strlen($nome) == 0) {
            $this->erros[] = "Informe o nome";
        }
        if (strlen($entrada) == 0) {
            $this->erros[] = "Informe a data de entrada";
        }
        if (strlen($id_grupo) == 0) {
            $this->erros[] = "Informe o grupo";
        }
        if (!$this->erros) {
            $this->funcionario = new Funcionario($cpf, $nome, $entrada, $saida, $id_funcao, $id_grupo, $id);
            if ($this->daoFuncionario->editar($this->funcionario)) {
                return true;
            }
        } else {
            $this->erros[] = "Erro ao editar o registro";
            return false;
        }
    }

    public function excluir($id)
    {
        if ($this->daoFuncionario->excluir($id)) {
            return true;
        } else {
            $this->erros[] = "Erro eo excluir o registro";
            return false;
        }
    }

    public function listar()
    {
        return $this->daoFuncionario->listar();
    }

    public function selecionar($id)
    {
        return $this->daoFuncionario->selecionar($id);
    }

    function getErros()
    {
        return $this->erros;
    }
}
