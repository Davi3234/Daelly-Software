<?php
require_once 'constants.php';
require_once 'auth.service.php';

class AuthController {
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new AuthController();
        }

        return self::$instance;
    }

    private function __construct()
    {
    }

    public function perform($request, $response)
    {
        $router = $request->getParam('router');

        $action = remove_start_str($this->getBaseRouter(), $router);

        if (str_starts_with(AUTH_ACTION_ROUTERS::Login->value, $action) && AUTH_METHODS_ROUTERS::Login->value == $request->getHeader('REQUEST_METHOD')) {
            return AuthService::getInstance()->login($request->getAllBody());
        }

        return "Cannot found action";
    }

    private function getBaseRouter()
    {
        return PREFIX_CONTROLLERS::Auth->value;
    }
}