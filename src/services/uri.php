<?php

class URI
{
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new URI();
        }

        return self::$instance;
    }

    protected function getProtocol()
    {
        if (strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === false) {
            return 'http://';
        }

        return 'https://';
    }

    protected function getHost()
    {
        return $_SERVER['HTTP_HOST'];
    }

    protected function getScriptName()
    {
        $scr = dirname($_SERVER['SCRIPT_NAME']);

        if (empty($scr) && substr_count($scr, '/') <= 1) {
            return '';
        }
        return $scr;
    }

    public function getBase()
    {
        return self::getProtocol() . self::getHost() . self::getScriptName();
    }
}
