<?php

class UserCreateUseCase
{
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new UserCreateUseCase();
        }

        return self::$instance;
    }

    function perform($data)
    {
        return $data;
    }
}
