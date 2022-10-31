<?php
class ControlCliente
{

    private $cliente;
    private $daoCliente;
    private $erros;

    public function __construct()
    {
        $this->cliente = new Cliente();
        $this->daoCliente = new DaoCliente();
        $this->erros = array();
    }

    public function inserir($nome, $cpf, $email, $telefone, $data_nascimento)
    {
        if (strlen($nome) == 0) {
            $this->erros[] = "Informe o seu nome";
        }
        if (strlen($cpf) == 0) {
            $this->erros[] = "Informe o seu CPF";
        }
        if (strlen($email) == 0) {
            $this->erros[] = "Informe o seu email";
        }
        if (strlen($telefone) == 0) {
            $this->erros[] = "Informe o seu telefone";
        }
        if (strlen($data_nascimento) == 0) {
            $this->erros[] = "Informe a sua data de nascimento";
        }
        if (!$this->erros) {
            $this->cliente = new Cliente($nome, $cpf, $email, $telefone, $data_nascimento);
            if ($this->daoCliente->inserir($this->cliente)) {
                return true;
            } else {
                $this->erros[] = "Erro ao inserir o registro";
                return false;
            }
        } else {
            return false;
        }
    }

    public function editar($nome, $cpf, $email, $telefone, $data_nascimento, $id)
    {
        if (strlen($nome) == 0) {
            $this->erros[] = "Informe o seu nome";
        }
        if (strlen($cpf) == 0) {
            $this->erros[] = "Informe o seu CPF";
        }
        if (strlen($email) == 0) {
            $this->erros[] = "Informe o seu email";
        }
        if (strlen($telefone) == 0) {
            $this->erros[] = "Informe o seu telefone";
        }
        if (strlen($data_nascimento) == 0) {
            $this->erros[] = "Informe a sua data de nascimento";
        }
        if (!$this->erros) {
            $this->cliente = new Cliente($nome, $cpf, $email, $telefone, $data_nascimento, $id);
            if ($this->daoCliente->editar($this->cliente)) {
                return true;
            }
        } else {
            $this->erros[] = "Erro ao editar o registro";
            return false;
        }
    }

    public function excluir($id)
    {
        if ($this->daoCliente->excluir($id)) {
            return true;
        } else {
            $this->erros[] = "Erro eo excluir o registro";
            return false;
        }
    }

    public function listar()
    {
        return $this->daoCliente->listar();
    }

    public function selecionar($id)
    {
        return $this->daoCliente->selecionar($id);
    }

    function getErros()
    {
        return $this->erros;
    }
}
