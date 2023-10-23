<?php

class ApiRepository {
    private static $instance;

    private $endpoints;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new ApiRepository();
        }

        return self::$instance;
    }

    private function __construct() {
        $this->endpoints = [];
    }

    function add($instance, $name, ...$handlers) {
        $this->endpoints[$name] = ['handlers' => $handlers, 'instance' => $instance];

        $this->handler($name, ['hello' => 'world']);
    }

    function handler($name, $body = []) {
        $endpoint = $this->getHandler($name);

        if (!isset($endpoint)) {
            return;
        }

        if (!isset($endpoint['instance'])) {
            return ;
        }

        foreach ($endpoint['handlers'] as $handler) {
            if (is_callable([$endpoint['instance'], $handler])) {
                return call_user_func_array([$endpoint['instance'], $handler], $body);
            } else {
                echo '!!';
            }
        }
    }

    function getHandler($name) {
        if (isset($this->endpoints[$name])) {
            return $this->endpoints[$name];
        }

        return null;
    }
}