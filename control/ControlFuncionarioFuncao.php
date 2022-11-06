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
        $this->erro = "Erro ao atualizar as funções do funionário";
        return false;
    }

    public function atualizarFuncoes($id_funcionario, $funcoesAtuais = array()) {
        $funcoesOriginais = $this->listarByFuncionario($id_funcionario);

        // if ($funcoesAtuais) foreach($funcoesAtuais as $fa) {
        //     if (!is_array($funcoesOriginais) || !in_array($fa, $funcoesOriginais)) {
        //         $this->inserir($id_funcionario, $fa);
        //     }
        // }

        // if ($funcoesOriginais) foreach($funcoesOriginais as $fo) {
        //     if (!is_array($funcoesAtuais) || !in_array($fo, $funcoesAtuais)) {
        //         $this->excluir($id_funcionario, $fo);
        //     }
        // }
    }

    public function excluir($id_funcionario, $id_funca)
    {
        if ($this->daoFuncionarioFuncao->excluir($id_funca, $id_funcionario)) {
            return true;
        } else {
            $this->erro = "Erro ao atualizar as funções do funionário";
            return false;
        }
    }

    public function excluirByFuncionario($id_funcionario)
    {
        if ($this->daoFuncionarioFuncao->excluirByFuncionario($id_funcionario)) {
            return true;
        } else {
            $this->erro = "Erro ao atualizar as funções do funionário";
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
