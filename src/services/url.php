<?php

class URL {
    private static $instance;

    static function getInstance() {
        if(!isset(self::$instance)) {
            self::$instance = new URL();
        }

        return self::$instance;
    }

    function getURL() {
        return $this->getURLBase() . $this->getURLRouters();
    }

    function getURLBase() {
        $pageURL = 'http';
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"];
        }
        return $pageURL;
    }

    function getURLRouters() {
        $router = $_SERVER["REQUEST_URI"];

        if (substr($router, -1) == "/") {
            $router = substr($router, 0, -1);
        }

        return $router;
    }

    function getRouterArgs() {
        return explode("/", substr($this->getURLRouters(), 1));
    }

    function getRouterArgsByIndex($index) {
        return explode("/", substr($this->getURLRouters(), 1))[$index];
    }
}
