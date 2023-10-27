<?php 

class AuthLoginUseCase {
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new AuthLoginUseCase();
        }

        return self::$instance;
    }

    function perform($data) {
        return $data;
    }
}