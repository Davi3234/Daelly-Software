<?php
require_once 'user.controller.php';

class UserModule extends Module
{
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new UserModule();
        }

        return self::$instance;
    }

    private function __construct()
    {
        parent::__construct([
            'controllers' => ['users' => 'src/app/modules/user/user.controller.php']
        ]);
    }
}
