<?php
class ControlFuncionarioFuncao
{

    private $funcionariofuncao;
    private $daoFuncionarioFuncao;
    private $erro;

    public function __construct()
    {
        $this->funcionariofuncao = new FuncionarioFuncao();
        $this->daoFuncionarioFuncao = new DaoFuncionarioFuncao();
        $this->erro = null;
    }

    public function inserir($id_funci, $id_funca)
    {
        $this->funcionariofuncao = new FuncionarioFuncao($id_funci, $id_funca);
        if ($this->daoFuncionarioFuncao->inserir($this->funcionariofuncao)) {
            return true;
        }
        $this->erro = "Erro ao atualizar as funções do Funcionário";
        return false;
    }

    public function vincularFuncoes($id_funcionario, $funcoesAtuais = array()) {
        $this->daoFuncionarioFuncao->iniciarTransacao();
        if ($funcoesAtuais) foreach ($funcoesAtuais as $fa) {
            if (!$this->inserir($id_funcionario, $fa)) {
                $this->daoFuncionarioFuncao->rollback();
                return false;
            }
        }
        $this->daoFuncionarioFuncao->commit();
        return true;
    }

    public function atualizarFuncoes($id_funcionario, $funcoesAtuais = array())
    {
        if ($this->listarByFuncionario($id_funcionario)) {
            $this->excluirByFuncionario($id_funcionario);
        }

        return $this->vincularFuncoes($id_funcionario, $funcoesAtuais);
    }

    public function excluir($id_funcionario, $id_funca)
    {
        if ($this->daoFuncionarioFuncao->excluir($id_funca, $id_funcionario)) {
            return true;
        } else {
            $this->erro = "Erro ao atualizar as funções do Funcionário";
            return false;
        }
    }

    public function excluirByFuncionario($id_funcionario)
    {
        if ($this->daoFuncionarioFuncao->excluirByFuncionario($id_funcionario)) {
            return true;
        } else {
            $this->erro = "Erro ao atualizar as funções do Funcionário";
            return false;
        }
    }

    public function listar()
    {
        return $this->daoFuncionarioFuncao->listar();
    }

    public function listarByFuncionario($id)
    {
        return $this->daoFuncionarioFuncao->listarByFuncionario($id);
    }

    public function listarByFuncao($id)
    {
        return $this->daoFuncionarioFuncao->listarByFuncao($id);
    }

    function getErro()
    {
        return $this->erro;
    }
}
