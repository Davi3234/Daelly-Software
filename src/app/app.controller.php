<?php
include 'modules/auth/guards/authorization.guard.php';
include 'constants.php';

class AppController
{
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function perform(Request $request, Response $response)
    {
        $router = $request->getModule();

        if (isStartsWith(PREFIX_CONTROLLERS::User->value, $router)) {
            return $this->performUserController($request, $response);
        }

        if (isStartsWith(PREFIX_CONTROLLERS::Auth->value, $router)) {
            return $this->performAuthController($request, $response);
        }

        $error = new ErrorModel();
        $res = Result::failure($error->setTitle('HTTP Request')->setMessage('Router not found')->addCause('Router ' . $request->getHeader('REQUEST_METHOD') . ' "' . $router . '" not found')->getError(), 404);

        $response->send($res->getResult(), $res->getStatus());
    }

    private function performUserController(Request $request, Response $response)
    {
        include $this->getPathController('user');

        UserController::getInstance()->perform($request, $response);
    }

    private function performAuthController(Request $request, Response $response)
    {
        include $this->getPathController('auth');

        AuthController::getInstance()->perform($request, $response);
    }

    private function getPathController($name)
    {
        $path = 'modules/' . $name . '/' . $name . '.controller.php';

        return $path;
    }
}
