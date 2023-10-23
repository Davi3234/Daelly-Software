<?php
require_once 'user.service.php';

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
        ApiServer::getInstance()->post(self::$instance, 'user/create', 'create');
    }

    private function create($args) {
        echo $args;
    }
}
