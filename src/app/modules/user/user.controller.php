<?php

class UserController
{
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Router();
        }

        return self::$instance;
    }

    private function __construct()
    {
    }

    public function perform($request, $response)
    {
        echo '!';
    }
}
