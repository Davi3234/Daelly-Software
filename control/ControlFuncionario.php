<?php
class ControlFuncionario
{

    private $funcionario;
    private $daoFuncionario;
    private $controlFuncaFunci;
    private $erros;

    public function __construct()
    {
        $this->funcionario = new Funcionario();
        $this->daoFuncionario = new DaoFuncionario();
        $this->controlFuncaFunci = new ControlFuncionarioFuncao();
        $this->erros = array();
    }

    public function inserir($cpf, $nome, $entrada, $saida = null, $id_grupo = null)
    {
        if (strlen($cpf) == 0) {
            $this->erros[] = "Informe o CPF";
        } else if ($this->selecionarByCpf($cpf)) {
            $this->erros[] = "CPF de funionário já cadastrado";
        }
        if (strlen($nome) == 0) {
            $this->erros[] = "Informe o nome";
        }
        if (strlen($entrada) == 0) {
            $this->erros[] = "Informe a data de entrada";
        }
        if (!$this->erros) {
            $this->funcionario = new Funcionario($cpf, $nome, $entrada, $saida, $id_grupo == 0 ? null : $id_grupo);
            if ($this->daoFuncionario->inserir($this->funcionario)) {
                return true;
            }
            $this->erros[] = "Erro ao inserir o registro";
            return false;
        }
        return false;
    }

    public function editar($cpf, $nome, $entrada, $saida, $id_grupo, $id)
    {
        if (strlen($cpf) == 0) {
            $this->erros[] = "Informe o CPF";
        } else if ($this->selecionar($id)->cpf != $cpf && $this->selecionarByCpf($cpf)) {
            $this->erros[] = "CPF de funionário já cadastrado";
        }
        if (strlen($nome) == 0) {
            $this->erros[] = "Informe o nome";
        }
        if (strlen($entrada) == 0) {
            $this->erros[] = "Informe a data de entrada";
        }
        if (!$this->erros) {
            $this->funcionario = new Funcionario($cpf, $nome, $entrada, $saida, $id_grupo == 0 ? null : $id_grupo, $id);
            if ($this->daoFuncionario->editar($this->funcionario)) {
                return true;
            }
            $this->erros[] = "Erro ao editar o registro";
            return false;
        }
        return false;
    }

    public function vincularFuncoes($id, $funcoes = array())
    {
        $this->controlFuncaFunci->atualizarFuncoes($id, $funcoes);
        if ($this->controlFuncaFunci->getErro()) {
            $this->erros[] = $this->controlFuncaFunci->getErro();
            return false;
        }
        return true;
    }

    public function excluir($id)
    {
        if ($this->daoFuncionario->excluir($id) && $this->controlFuncaFunci->excluirByFuncionario($id)) {
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

    public function listarByFuncao($id_funcao)
    {
        return $this->daoFuncionario->listarByFuncao($id_funcao);
    }

    public function listarByGrupo($id_grupo)
    {
        return $this->daoFuncionario->listarByGrupo($id_grupo);
    }

    public function selecionar($id)
    {
        return $this->daoFuncionario->selecionar($id);
    }

    public function selecionarByCpf($cpf)
    {
        return $this->daoFuncionario->selecionarByCpf($cpf);
    }

    function getErros()
    {
        return $this->erros;
    }
}
