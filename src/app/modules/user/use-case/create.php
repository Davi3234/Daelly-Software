<?php

class UserCreateUseCase
{
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function perform($data)
    {
        $res = Repository::getInstance()->exec("INSERT INTO administrador (nome, email, senha, tentativas, ultimo_acesso) VALUES ('" . $data['username'] .  "', '" . $data['email'] .  "', '" . $data['password'] .  "', 0, '2023-10-30 10:00:00')");

        return $res;
    }
}
