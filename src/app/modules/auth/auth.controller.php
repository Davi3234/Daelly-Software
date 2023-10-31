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
        $router = $request->getParam('router');

        $action = remove_start_str($this->getBaseRouter(), $router);

        if (str_starts_with(AUTH_ACTION_ROUTERS::SignIn->value, $action) && AUTH_METHODS_ROUTERS::SignIn->value == $request->getHeader('REQUEST_METHOD')) {
            return $this->performSignIn($request, $response);
        }

        $res = Result::failure(ErrorModel::getInstance()->setTitle('HTTP Request')->setMessage('Router not found')->addCause('Router ' . $request->getHeader('REQUEST_METHOD') . ' "' . $router . '" not found')->finally(), 404);

        $response->send($res->getResult(), $res->getStatus());
    }

    private function performSignIn(Request $request, Response $response)
    {
        $responseData = AuthService::getInstance()->signin($request->getAllBody());

        return $response->send($responseData->getResult(), $responseData->getStatus());
    }

    private function getBaseRouter()
    {
        return PREFIX_CONTROLLERS::Auth->value;
    }
}
