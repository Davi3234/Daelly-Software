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
        $this->loadModule($appModule);
        $this->loadRouter($publicBasePath);
    }

    function loadModule($appModule)
    {
        $this->appModule = $appModule;
        $this->appModule->initComponents();
    }

    function loadRouter($publicBasePath)
    {
        Render::getInstance()->initComponents($publicBasePath);
        Render::getInstance()->loadIndexRouter();
    }

    function getAppModule() {
        return $this->appModule;
    }

    function getControllerByName($name) {
        return $this->appModule->getControllerByName($name);
    }

    function getRelationControllers() {
        $controllers = $this->appModule->getControllers();

        foreach($this->appModule->getImports() as $import) {
            foreach ($import->getControllers() as $key => $controller) {
                $controllers[$key] = $controller;
            }
        }

        return $controllers;
    }
}
