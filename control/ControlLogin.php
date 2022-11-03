<?php

class ControlLogin {
    private $daoLog;
    private $err;
    private $adm;

    public function __construct() {
        $this->daoLog = new DaoLogin();
        $this->adm = new Administrador();
        $this->err = null;
    }

    public function getErr() {
        return $this->err;
    }

    private function setValores($email, $senha) {
        $this->adm->setEmail($email);
        $this->adm->setSenha(md5($senha));
    }

    private function verificarValores($email, $senha) {
        $this->setValores($email, $senha);

        if ($email == "" || $senha == "") {
            $this->err = "O campo do senha e email é obrigatório";
            return false;
        } 
        if (!$this->daoLog->verificarEmail($this->adm)) {
            $this->err = "Email ou senha incorreto";
            return false;
        }

        return true;
    }

    public function executarLogin($email, $senha) {
        if (!$this->verificarValores($email, $senha)) { 
            return false;
        }
        
        if ($this->daoLog->getTentativas($this->adm) >= 3) {
            $this->err = "Usuário bloqueado";
            return false;
        }

        return $this->efetuarLogin();
    }

    private function efetuarLogin() {
        if (!$this->daoLog->efetuarLogin($this->adm)) {
            $this->daoLog->incrementarTentativa($this->adm);
            $this->err = "Email ou senha incorreto";
            return false;
        }

        $this->daoLog->zerarTentativas($this->adm);
        $this->daoLog->atualizarUltimoAcesso($this->adm);
        
        $_SESSION["email"] = $this->adm->getEmail();
        
        return true;
    }

    public function efetuarLogout() {
        $_SESSION["email"] = null;
        session_destroy();
    }
}
