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

    public function inserir($descricao, $data_manutencao, $id_maquina_costura = null, $id_compressor = null)
    {
        if (strlen($descricao) == 0) {
            $this->erros[] = "Informe a descrição";
        }
        if (strlen($data_manutencao) == 0) {
            $this->erros[] = "Informe a data da Manutenção";
        }
        if ($id_maquina_costura == 0 && $id_compressor == 0) {
            $this->erros[] = "Informe pelo menos uma máquina ou um compressor";
        } else if ($id_maquina_costura != 0 && $id_compressor != 0) {
            $this->erros[] = "Informe apenas uma máquina ou um compressor";
        } else {
            if ($id_maquina_costura == 0) {
                $id_maquina_costura = null;
            } else {
                $id_compressor = 0;
            }
        }
        if (!$this->erros) {
            $this->manutencao = new Manutencao($descricao, $data_manutencao, $id_maquina_costura, $id_compressor);
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

    public function editar($descricao, $data_manutencao, $id)
    {
        if (strlen($descricao) == 0) {
            $this->erros[] = "Informe a descrição";
        }
        if (strlen($data_manutencao) == 0) {
            $this->erros[] = "Informe a data da Manutenção";
        }
        if (!$this->erros) {
            $this->manutencao = new Manutencao($descricao, $data_manutencao, null, null, $id);
            if ($this->daoManutencao->editar($this->manutencao)) {
                return true;
            }
            $this->erros[] = "Erro ao editar o registro";
            return false;
        }
        return false;
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

    public function excluirByMaquina($id)
    {
        if ($this->daoManutencao->excluirByMaquina($id)) {
            return true;
        } else {
            $this->erros[] = "Erro eo excluir as manutenções dessa máquina";
            return false;
        }
    }

    public function excluirByCompressor($id)
    {
        if ($this->daoManutencao->excluirByCompressor($id)) {
            return true;
        } else {
            $this->erros[] = "Erro eo excluir as manutenções desse compressor";
            return false;
        }
    }

    public function listar()
    {
        return $this->daoManutencao->listar();
    }

    public function listarByMaquina($id)
    {
        return $this->daoManutencao->listarByMaquina($id);
    }

    public function listarByCompressor($id)
    {
        return $this->daoManutencao->listarByCompressor($id);
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
