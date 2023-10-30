<?php
require_once 'src/services/api/index.php';
require_once 'src/app/app.controller.php';

class App
{
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function factory($publicBasePath = '', $componentBasePath = '')
    {
        $this->loadRouter($publicBasePath, $componentBasePath);
    }

    function loadRouter($publicBasePath, $componentBasePath)
    {
        Render::getInstance()->initComponents($publicBasePath, $componentBasePath);
        Render::getInstance()->loadIndexRouter();
    }
}
