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

    function performHandler($request, $response)
    {
        $router = $request->getParam('router');

        $nameModule = explode('/', remove_start_str('/', $router))[0];

        AppController::getInstance()->perform($nameModule, $request, $response);
    }
}
