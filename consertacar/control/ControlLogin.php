<?php
class ControlLogin {

    private $admin;
    private $daoLog;
    private $erros;

    public function __construct() {
        $this->admin = new Administrador();
        $this->daoLog = new DaoLogin();
        $this->erros = array();
    }

    public function setValores($email = null, $senha = null, $nome = null, $tentativas = null, $ultimoAcesso = null, $id = null){
        $this->admin = new Administrador($nome, $email, $senha, $tentativas, $ultimoAcesso, $id); 
    }

    public function verificarValores($email, $senha){
        $this->setValores($email, $senha);
        if($this->daoLog->verificarEmail($this->admin)){

        }else{
        }
    }

    public function efetuarLogin($email, $senha){
        $this->setValores($email, $senha);
        if($this->daoLog->verificarEmail($this->admin)){
            if($this->daoLog->efetuarLogin($this->admin)){
                $this->daoLog->atualizarUltimoAcesso($this->admin);
                $this->daoLog->zerarTentativas($this->admin);
                $_SESSION['email'] = $this->admin->getEmail();
            return true;
            }
        }else{
            $this->daoLog->incrementarTentativa($this->admin);
            $this->erros[] = "E-mail ou senha incorretos";
            return false;
        }

    }

    public function getAdmin(){
        return $this->admin;
    }

    function getErros() {
        return $this->erros;
    }

    function efetuarLogout(){
        $_SESSION['email'] = null;
        session_destroy();
    }


}
