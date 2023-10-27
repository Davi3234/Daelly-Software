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

    public function perform(Request $request, Response $response)
    {
        $router = $request->getParam('router');

        $action = remove_start_str($this->getBaseRouter(), $router);

        if (str_starts_with(USER_ACTION_ROUTERS::Create->value, $action) && USER_METHODS_ROUTERS::Create->value == $request->getHeader('REQUEST_METHOD')) {
            return $this->performCreate($request, $response);
        }

        $response->send("Cannot found action", 404);
    }

    private function performCreate(Request $request, Response $response)
    {
        $responseData = UserService::getInstance()->create($request->getAllBody());

        return $response->send($responseData);
    }

    private function getBaseRouter()
    {
        return PREFIX_CONTROLLERS::User->value;
    }
}
