<?php

class DaoManutencao
{

    private $conexao;

    function __construct()
    {
        try {
            include "../config/db-config.php";
            $this->conexao = new PDO("mysql:host=localhost;dbname=" . $GLOBALS["dbname"], $GLOBALS["user"], $GLOBALS["pass"]);
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
    }

    function inserir(Manutencao $manutencao)
    {
        try {
            if ($manutencao->getIdMaquina()) {
                return $this->conexao->exec("insert into manutencao (descricao, data_manutencao, id_maquina_costura) values ('" . $manutencao->getDescricao() . "','" . $manutencao->getDataManutencao() . "'," . $manutencao->getIdMaquina() . ")");
            } else {
                return $this->conexao->exec("insert into manutencao (descricao, data_manutencao, id_compressor) values ('" . $manutencao->getDescricao() . "','" . $manutencao->getDataManutencao() . "'," . $manutencao->getIdCompresor() . ")");
            }
        } catch (PDOException $ex) {
            return false;
        }
    }

    function editar(Manutencao $manutencao)
    {
        try {
            $this->conexao->exec("update manutencao set descricao='" . $manutencao->getDescricao() . "', data_manutencao ='" . $manutencao->getDataManutencao() . "' where id=" . $manutencao->getId());
            return true;
        } catch(PDOException $ex) {
            return false;
        }
    }

    function excluir($id)
    {
        try {
            return $this->conexao->exec("delete from manutencao where id=" . $id);
        } catch (PDOException $exc) {
            return false;
        }
    }

    function excluirByMaquina($id)
    {
        try {
            $this->conexao->exec("delete from manutencao where id_maquina_costura=" . $id);
            return true;
        } catch (PDOException $exc) {
            return false;
        }
    }

    function excluirByCompressor($id)
    {
        try {
            $this->conexao->exec("delete from manutencao where id_compressor=" . $id);
            return true;
        } catch (PDOException $exc) {
            return false;
        }
    }

    function listar()
    {
        try {
            return $this->conexao->query("select m.*, maq.codigo as maquina, t.nome as tipo, c.codigo as compressor from manutencao m left join maquina_costura maq on maq.id = m.id_maquina_costura left join tipo t on t.id = maq.id_tipo left join compressor c on c.id = m.id_compressor order by m.data_manutencao desc", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    function listarByMaquina($id)
    {
        try {
            return $this->conexao->query("select * from manutencao where id_maquina_costura = " . $id . " order by data_manutencao desc", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    function listarByCompressor($id)
    {
        try {
            return $this->conexao->query("select * from manutencao where id_compressor = " . $id . " order by data_manutencao desc", PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    function selecionar($id)
    {
        try {
            return $this->conexao->query("select * from manutencao where id = " . $id)->fetchObject();
        } catch (PDOException $ex) {
            return false;
        }
    }
}
