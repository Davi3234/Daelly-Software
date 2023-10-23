<?php

class URL
{
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new URL();
        }

        return self::$instance;
    }

    function getURL()
    {
        return $this->getURLBase() . $this->getURLRouters();
    }

    function redirect($url)
    {
        header($this->getURLRedirect($url));
    }

    function getURLRedirect($url)
    {
        if (substr($url, 0, 1) != '/') {
            $url = '/' . $url;
        }

        return '/' . $GLOBALS['GLOBAL_PREFIX_ROUTER'] . $url;
    }

    function getURLBase()
    {
        $pageURL = 'http';

        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $pageURL .= 's';
        }

        $pageURL .= '://';

        if ($_SERVER['SERVER_PORT'] != '80') {
            $pageURL .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'];
        } else {
            $pageURL .= $_SERVER['SERVER_NAME'];
        }

        return $pageURL;
    }

    function getURLRouters()
    {
        $router = str_replace('//', '/', $this->getBaseRouter() ? str_replace('/' . $this->getBaseRouter(), '', $_SERVER['REQUEST_URI']) : $_SERVER['REQUEST_URI']);

        while (substr($router, -1) == '/') {
            $router = substr($router, 0, -1);
        }
        while (substr($router, 0, 1) == '/') {
            $router = substr($router, 1);
        }

        return $router;
    }

    function getBaseRouter()
    {
        return $GLOBALS['GLOBAL_PREFIX_ROUTER'];
    }

    function getURLRoutersPaths()
    {
        return explode('/', $this->getURLRouters());
    }

    function getURLRoutersPathsByIndex($index)
    {
        return explode('/', $this->getURLRouters())[$index];
    }
}
