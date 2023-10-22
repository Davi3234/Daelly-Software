<?php

class UserController extends Controller
{
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new UserController();
        }

        return self::$instance;
    }

    private function __construct()
    {
        parent::__construct();
    }

    function initComponents()
    {
    }
}
