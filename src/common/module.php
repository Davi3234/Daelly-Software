<?php

abstract class Module
{
    private $imports;
    private $controllers;

    function __construct($args = [])
    {
        $this->imports = isset($args['imports']) ? $args['imports'] : [];
        $this->controllers = isset($args['controllers']) ? $args['controllers'] : [];
    }

    function initComponents()
    {
        foreach ($this->getImports() as $import) {
            $import->initComponents();
        }
        foreach ($this->getControllers() as $controller) {
            $controller->initComponents();
        }
    }

    function getImports()
    {
        return $this->imports;
    }

    function getControllers()
    {
        return $this->controllers;
    }

    function getControllerByName($name)
    {
        foreach($this->getControllers() as $controller) {
            if ($controller->getName() == $name) {
                return $controller;
            }
        }

        return null;
    }
}
