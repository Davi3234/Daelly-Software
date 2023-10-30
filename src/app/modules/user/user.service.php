<?php

class UserService
{
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function create($data)
    {
        include $this->getPathUseCase('create');

        return UserCreateUseCase::getInstance()->perform($data);
    }

    private function getPathUseCase($name)
    {
        $path = 'use-case/' . $name . '.php';

        return $path;
    }
}
