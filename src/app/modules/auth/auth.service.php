<?php

class AuthService
{
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function signin($data)
    {
        require_once $this->getPathUseCase('sign-in');

        return AuthSignInUseCase::getInstance()->perform($data);
    }

    private function getPathUseCase($name)
    {
        $path = 'use-case/' . $name . '.php';

        return $path;
    }
}
