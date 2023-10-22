<?php
require_once 'use-case/create.php';

class UserService
{
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new UserService();
        }

        return self::$instance;
    }

    private function __construct()
    {
    }

    function create()
    {
        $response = UserCreateUseCase::getInstance()->perform();

        return $response;
    }
}
