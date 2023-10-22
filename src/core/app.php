<?php
require_once 'render.php';

class App
{

    private static $instance;
    private Module $appModule;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new App();
        }

        return self::$instance;
    }

    function factory($publicBasePath, Module $appModule)
    {
        $this->appModule = $appModule;
        Render::getInstance()->initComponents($publicBasePath);
        $this->loadModule();
        $this->loadIndexRouter();
    }

    function loadIndexRouter()
    {
        Render::getInstance()->loadIndexRouter();
    }

    function loadModule()
    {
        $this->appModule->initComponents();
    }
}
