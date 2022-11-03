<?php
class DaoLogin{
    private $conexao;

    public function __construct(){
        $this->conexao = new PDO("mysql:host=localhost;port=3306;dbname=daelly", "root", "root");
    }

    public function verificarEmail(Administrador $admin){
        return $this->conexao->query("select * from administrador where email = '".$admin->getEmail()."'")->fetchObject();
    }

    public function efetuarLogin(Administrador $admin){
        return $this->conexao->query("select * from administrador where email = '".$admin->getEmail()."' and senha = '".$admin->getSenha()."'")->fetchObject();
    }

    public function getTentativas(Administrador $admin){
        return $this->conexao->query("select tentativas from administrador where email = '".$admin->getEmail()."'")->fetchColumn();
    }

    public function incrementarTentativa(Administrador $admin){
        return $this->conexao->exec("update administrador set tentativas = tentativas + 1 where email = '".$admin->getEmail()."'");
    }

    public function atualizarUltimoAcesso(Administrador $admin){
        return $this->conexao->exec("update administrador set ultimo_acesso = now() where email = '".$admin->getEmail()."'");
    }

    public function zerarTentativas(Administrador $admin){
        return $this->conexao->exec("update administrador set tentativas = 0 where email = '".$admin->getEmail()."'");
    }
}
?>