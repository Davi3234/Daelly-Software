<?php

class Cookie {
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function set($name, $value, $exp = 0) {
        $timeExp = '';
        if (isset($exp)) {
            $timeExp = time() + $exp;
        }
        return setcookie($name, $value, $timeExp, "/");
    }

    function get($name) {
        if (isset($_COOKIE[$name])) {
            return $_COOKIE[$name];
        }

        return '';
    }

    function remove($name) {
        setcookie($name, "", time() - 60, "/");
    }
}