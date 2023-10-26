<?php
include 'constants.php';

class AppController
{
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new AppController();
        }

        return self::$instance;
    }

    function perform(Request $request, Response $response)
    {
        $router = $request->getParam('router');

        if (isStartsWith(PREFIX_CONTROLLERS::User->value, $router)) {
            return $this->perforUserController($request, $response);
        }

        return "Cannot found controller";
    }

    private function perforUserController(Request $request, Response $response) {
        include $this->getPathController('user');

        return UserController::getInstance()->perform($request, $response);
    }

    private function getPathController($name) {
        $path = 'modules/' . $name . '/' . $name . '.controller.php';

        return $path;
    }
}
