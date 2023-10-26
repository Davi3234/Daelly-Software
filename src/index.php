<?php
require_once 'src/services/api/index.php';
require_once 'src/app/app.controller.php';

class App
{
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new App();
        }

        return self::$instance;
    }

    function factory($publicBasePath)
    {
        $this->loadRouter($publicBasePath);
    }

    function loadRouter($publicBasePath)
    {
        Render::getInstance()->initComponents($publicBasePath);
        Render::getInstance()->loadIndexRouter();
    }
}
