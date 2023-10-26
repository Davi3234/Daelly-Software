<?php
require_once 'request.php';
require_once 'response.php';

class Api
{
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Api();
        }

        return self::$instance;
    }

    private function __construct()
    {
    }

    function performHandler(Request $request, Response $response)
    {
        return AppController::getInstance()->perform($request, $response);
    }
}
