<?php
require_once 'constants.php';
require_once 'auth.service.php';

class AuthController
{
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
    }

    public function perform($request, $response)
    {
        $router = $request->getModule();
        $action = $request->getAction();

        if (isStartsWith(AUTH_ACTION_ROUTERS::SignIn->value, $action) && AUTH_METHODS_ROUTERS::SignIn->value == $request->getHeader('REQUEST_METHOD')) {
            return $this->performSignIn($request, $response);
        }

        $error = new ErrorModel();
        $res = Result::failure($error->setTitle('HTTP Request')->setMessage('Router not found')->addCause('Router ' . $request->getHeader('REQUEST_METHOD') . ' "' . $router . '" not found')->getError(), 404);

        $response->send($res->getResult(), $res->getStatus());
    }

    private function performSignIn(Request $request, Response $response)
    {
        $responseData = AuthService::getInstance()->signIn($request->getAllBody());

        return $response->send($responseData->getResult(), $responseData->getStatus());
    }
}
