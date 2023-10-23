<?php
require_once 'repository.php';

class ApiServer {
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new ApiServer();
        }

        return self::$instance;
    }

    private function __construct() {}

    function post($instance, $name, ...$handlers) {
        ApiRepository::getInstance()->add($instance, 'POST:' . $name, ...$handlers);
    }
}