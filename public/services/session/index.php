<?php

class Session {
    private static $instance;
    private $publicBasePath;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Session();
        }

        return self::$instance;
    }

}