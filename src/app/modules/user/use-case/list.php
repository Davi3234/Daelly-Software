<?php

class UserListUseCase
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
        $res = Repository::getInstance()->query('select * from administrador');

        return Result::success($res);
    }
}
