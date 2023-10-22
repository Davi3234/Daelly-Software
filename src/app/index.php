<?php
require_once 'modules/user/user.module.php';

class AppModule extends Module
{
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new AppModule();
        }

        return self::$instance;
    }

    private function __construct()
    {
        parent::__construct(['imports' => [UserModule::getInstance()]]);
    }
}
