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

        foreach ($res as $key => $user) {
            unset($res[$key]['senha']);
        }

        return Result::success($res);
    }
}
