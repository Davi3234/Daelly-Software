<?php

class AppController
{
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new AppController();
        }

        return self::$instance;
    }

    function perform($name, $request, $perform)
    {
        echo $name;
    }
}
