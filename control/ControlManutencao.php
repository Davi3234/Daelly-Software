<?php
class ControlManutencao
{

    private $manutencao;
    private $daoManutencao;
    private $erros;

    public function __construct()
    {
        $this->manutencao = new Manutencao();
        $this->daoManutencao = new DaoManutencao();
        $this->erros = array();
    }

    public function inserir($descricao = null, $data_manutencao = null, $id_maquina = null, $id_compressor = null)
    {
        if (strlen($descricao) == 0) {
            $this->erros[] = "Informe a descrição";
        }
        if (strlen($data_manutencao) == 0) {
            $this->erros[] = "Informe a data da manutenção";
        }
        if ($id_maquina == 0 && $id_compressor == 0) {
            $this->erros[] = "Informe pelo menos uma máquina ou um compressor";
        }
        if (!$this->erros) {
            $this->manutencao = new Manutencao($descricao, $data_manutencao, $id_maquina, $id_compressor);
            if ($this->daoManutencao->inserir($this->manutencao)) {
                return true;
            } else {
                $this->erros[] = "Erro ao inserir o registro";
                return false;
            }
        } else {
            return false;
        }
    }

    public function editar($descricao, $data_manutencao, $id_maquina, $id_compressor, $id)
    {
        if (strlen($descricao) == 0) {
            $this->erros[] = "Informe a descrição";
        }
        if (strlen($data_manutencao) == 0) {
            $this->erros[] = "Informe a data da manutenção";
        }
        if (!$this->erros) {
            $this->manutencao = new Manutencao($descricao, $data_manutencao, $id_maquina, $id_compressor, $id);
            if ($this->daoManutencao->editar($this->manutencao)) {
                return true;
            }
        } else {
            $this->erros[] = "Erro ao editar o registro";
            return false;
        }
    }

    public function excluir($id)
    {
        if ($this->daoManutencao->excluir($id)) {
            return true;
        } else {
            $this->erros[] = "Erro eo excluir o registro";
            return false;
        }
    }

    public function listar()
    {
        return $this->daoManutencao->listar();
    }

    public function selecionar($id)
    {
        return $this->daoManutencao->selecionar($id);
    }

    function getErros()
    {
        return $this->erros;
    }
}
