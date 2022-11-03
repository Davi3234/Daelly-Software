<?php

class ControlAdministrador {

    private $administrador;
    private $daoAdministrador;
    private $erros;

    public function __construct() {
        $this->administrador = new Administrador();
        $this->daoAdministrador = new DaoAdministrador();
        $this->erros = array();
    }

    public function inserir($nome, $email, $senha) {
        if (strlen($nome) == 0) {
            $this->erros[] = "Informe o seu nome";
        }
        if (strlen($email) == 0) {
            $this->erros[] = "Informe o seu e-mail";
        }
        if (strlen($senha) < 4 || strlen($senha) > 20) {
            $this->erros[] = "Informe uma senha entre 4 e 20 caracteres";
        }
        if(!$this->erros){
            $this->administrador = new Administrador($nome, $email, md5($senha));
            if($this->daoAdministrador->inserir($this->administrador)){
                return true;
            }else{
                $this->erros[] = "Erro ao inserir o registro";
                return false;
            }
        }else{
            return false;
        }
    }
    
    public function editar($nome, $email, $senha, $id){
         if (strlen($nome) == 0) {
            $this->erros[] = "Informe o seu nome";
        }
        if (strlen($email) == 0) {
            $this->erros[] = "Informe o seu e-mail";
        }
        
        if($senha){
            if (strlen($senha) < 4 || strlen($senha) > 20) {
                $this->erros[] = "Informe uma senha entre 4 e 20 caracteres";
            }
        }
        if(!$this->erros){            
            $this->administrador = new Administrador($nome, $email);
            if($senha){
                $this->administrador->setSenha(md5($senha));
            }
            $this->administrador->setId($id);
            if($this->daoAdministrador->editar($this->administrador)){
                return true;
            }else{
                $this->erros[] = "Erro ao editar o registro";
                return false;
            }
        }else{
            return false;
        }
    }
    
    public function excluir($id){
        if($this->daoAdministrador->excluir($id)){
            return true;
        }else{
            $this->erros[] = "Erro eo excluir o registro";
            return false;
        }
    }
    
    public function listar(){
        return $this->daoAdministrador->listar();
    }
    
    public function selecionar($id){
        return $this->daoAdministrador->selecionar($id);
    }
    
    function getErros() {
        return $this->erros;
    }



}
