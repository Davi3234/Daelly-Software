<?php

class AuthService {
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new AuthService();
        }

        return self::$instance;
    }

    function login($data) {
        require_once $this->getPathUseCase('login');

        return AuthLoginUseCase::getInstance()->perform($data);
    }

    private function getPathUseCase($name) {
        $path = 'use-case/' . $name . '.php';

        return $path;
    }
}