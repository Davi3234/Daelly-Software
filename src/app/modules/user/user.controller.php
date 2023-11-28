<?php
require_once 'constants.php';
require_once 'user.service.php';

class UserController
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

    public function perform(Request $request, Response $response)
    {
        $router = $request->getModule();
        $action = $request->getAction();

        if (isStartsWith(USER_ACTION_ROUTERS::Create->value, $action) && USER_METHODS_ROUTERS::Create->value == $request->getHeader('REQUEST_METHOD')) {
            return $this->performCreate($request, $response);
        }

        if (isStartsWith(USER_ACTION_ROUTERS::List->value, $action) && USER_METHODS_ROUTERS::List->value == $request->getHeader('REQUEST_METHOD')) {
            return $this->performList($request, $response);
        }

        $err = new ErrorModel();

        $res = Result::failure($err->setTitle('HTTP Request')->setMessage('Router not found')->addCause('Router ' . $request->getHeader('REQUEST_METHOD') . ' "' . $router . '" not found'), 404);

        $response->send($res, $res->getStatus());
    }

    private function performCreate(Request $request, Response $response)
    {
        AuthorizationGuard::getInstance()->perform($request, $response);

        $responseData = UserService::getInstance()->create($request->getAllBody());

        return $response->send($responseData, $responseData->getStatus());
    }

    private function performList(Request $request, Response $response)
    {
        $responseData = UserService::getInstance()->list($request->getAllBody());

        return $response->send($responseData, $responseData->getStatus());
    }
}
