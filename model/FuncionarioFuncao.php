<?php

class FuncionarioFuncao {
    private $id_funcionario;
    private $id_funcao;
    
    function __construct($id_funcionario = null, $id_funcao = null) {
        $this->id_funcionario = $id_funcionario;
        $this->id_funcao = $id_funcao;
    }
    
    function getId_funcionario() {
        return $this->id_funcionario;
    }

    function getId_funcao() {
        return $this->id_funcao;
    }

    function setId_funcionario($id_funcionario) {
        $this->id_funcionario = $id_funcionario;
    }

    function setId_funcao($id_funcao) {
        $this->id_funcao = $id_funcao;
    }
}
