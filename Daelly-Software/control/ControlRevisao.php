<?php
class ControlRevisao
{

    private $revisao;
    private $daoRevisao;
    private $msg;
    private $erros;

    public function __construct()
    {
        $this->revisao = new Revisao();
        $this->daoRevisao = new DaoRevisao();
        $this->erros = array();
        $this->msg = array();
    }

    public function inserir($data_manutencao, $quilometragem, $id_veiculo)
    {
        if (strlen($data_manutencao) == 0) {
            $this->erros[] = "Informe a data da manutenção";
        }
        if ($quilometragem == 0) {
            $this->erros[] = "Informe a quilometragem";
        }
        if ($id_veiculo == 0) {
            $this->erros[] = "Informe o veículo";
        }
        if (!$this->erros) {
            $this->revisao = new Revisao($data_manutencao, $quilometragem, $id_veiculo);
            if ($this->verificarAtrasoData($data_manutencao)) {
                $this->msg[] = "A revisão estava atrasada por causa da data";
            }
            if($this->verificarAtrasoKm($quilometragem)){
                $this->msg[] = "A revisão estava atrasada por causa da quilometragem";
            }
            if ($this->daoRevisao->inserir($this->revisao)) {
                return true;
            } else {
                $this->erros[] = "Erro ao inserir o registro";
                return false;
            }
        } else {
            return false;
        }
    }

    public function editar($data_manutencao,  $quilometragem, $id_veiculo, $id)
    {
        if (strlen($data_manutencao) == 0) {
            $this->erros[] = "Informe data da manutencao";
        }
        if ($quilometragem == 0) {
            $this->erros[] = "Informe o cliente";
        }
        if ($id_veiculo == 0) {
            $this->erros[] = "Informe o veículo";
        }
        if (!$this->erros) {
            $this->revisao = new Revisao($data_manutencao, $quilometragem, $id_veiculo, $id);
            if ($this->daoRevisao->editar($this->revisao)) {
                return true;
            }
        } else {
            $this->erros[] = "Erro ao editar o registro";
            return false;
        }
    }

    public function excluir($id)
    {
        if ($this->daoRevisao->excluir($id)) {
            return true;
        } else {
            $this->erros[] = "Erro eo excluir o registro";
            return false;
        }
    }

    public function listar()
    {
        return $this->daoRevisao->listar();
    }


    public function selecionar($id)
    {
        return $this->daoRevisao->selecionar($id);
    }

    function getErros()
    {
        return $this->erros;
    }

    function verificarAtrasoData($data_manutencao)
    {
        return $this->mesDiferenca($data_manutencao) >= 1;
    }
    function verificarAtrasoKm($quilometro)
    {
        return $this->kmDiferenca($quilometro) >= 10000;
    }
    function mesDiferenca($data_manutencao)
    {
        return $this->daoRevisao->mesDiferenca($this->revisao->getIdVeiculo(), $data_manutencao) / 12;
    }

    function kmDiferenca($quilometro)
    {
        return $quilometro - $this->daoRevisao->kmDiferenca($this->revisao->getIdVeiculo());
    }

    public function getMsg()
    {
        return $this->msg;
    }
}
