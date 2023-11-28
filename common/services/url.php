<?php

class URL
{
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function getURL()
    {
        return $this->getURLBase() . remove_start_str('/' . $this->getURLRouters());
    }

    function redirect($url)
    {
        header($this->createURLPath($url));
    }

    function createURLPath($url)
    {
        $url = remove_start_str('/', $url);

        if (isset($GLOBALS['GLOBAL_PREFIX_ROUTER']) && $GLOBALS['GLOBAL_PREFIX_ROUTER']) {
            return '/' . $GLOBALS['GLOBAL_PREFIX_ROUTER'] . '/' . $url;
        }

        return '/' . $url;
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
        if (isset($_GET['url'])) {
            return $_GET['url'];
        }

        $router = str_replace('//', '/', $this->getBaseRouter() ? str_replace('/' . $this->getBaseRouter(), '', $_SERVER['REQUEST_URI']) : $_SERVER['REQUEST_URI']);

        while (isStartsWith('/', $router)) {
            $router = remove_start_str('/', $router);
        }
        while (isEndsWith('/', $router)) {
            $router = remove_end_str('/', $router);
        }

        return '/' . $router;
    }

    function getBaseRouter()
    {
        return $GLOBALS['GLOBAL_PREFIX_ROUTER'];
    }

    function getURLRoutersPaths()
    {
        return explode('/', remove_start_str('/' . $this->getURLRouters()));
    }

    function getURLRoutersPathsByIndex($index)
    {
        return explode('/', remove_start_str('/' . $this->getURLRouters()))[$index];
    }
}
