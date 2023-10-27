<?php
require_once 'constants.php';
require_once 'user.service.php';

class UserController
{
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new UserController();
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

        if (str_starts_with(ACTION_ROUTERS::Create->value, $action)) {
            return UserService::getInstance()->create($request->getAllBody());
        }

        return "Cannot found action";
    }

    private function getBaseRouter()
    {
        return PREFIX_CONTROLLERS::User->value;
    }
}
