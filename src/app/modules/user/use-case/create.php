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
        Repository::getInstance()->begin();
        $adm = Repository::getInstance()->query("SELECT * FROM administrador WHERE email = '" . $data['email'] . "'");

        if (isTruthy($adm)) {
            Repository::getInstance()->rollback();

            return Result::failure(ErrorModel::getInstance()->setTitle('Create Admin')->setMessage('Admin already exists')->finally());
        }

        $res = Repository::getInstance()->exec("INSERT INTO administrador (nome, email, senha, tentativas, ultimo_acesso) VALUES ('" . $data['username'] .  "', '" . $data['email'] .  "', '" . md5($data['password']) .  "', 0, '2023-10-30 10:00:00')");

        if (!$res) {
            Repository::getInstance()->rollback();

            return Result::failure(ErrorModel::getInstance()->setTitle('Create Admin')->setMessage('Error on create admin')->finally());
        }

        Repository::getInstance()->commit();
        return Result::success('Admin created with successfully');
    }
}
