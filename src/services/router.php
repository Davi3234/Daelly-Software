<?php
class Router {
    static function getCurrentURL() {
        return Router::getBaseURL() . Router::getRouterURL();
    }

    static function getBaseURL() {
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

    static function getRouterURL() {
        $router = $_SERVER["REQUEST_URI"];

        if (substr($router, -1) == "/") {
            $router = substr($router, 0, -1);
        }

        return $router;
    }

    static function getRouterArgs() {
        return explode("/", substr(Router::getRouterURL(), 1));
    }
}