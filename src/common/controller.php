<?php

abstract class Controller
{
    protected $name;

    function __construct($name)
    {
        if (!str_starts_with($name, '/')) {
            $name = '/' . $name;
        }

        $this->name = $name;
    }

    function initComponents()
    {
    }

    function getName() {
        return $this->name;
    }
}
