<?php
require_once 'src/common/module.php';
require_once 'src/common/controller.php';
require_once 'src/services/api/index.php';
require_once 'src/app/index.php';

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
