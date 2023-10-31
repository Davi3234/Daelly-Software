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
        $router = $request->getParam('router');

        $action = remove_start_str($this->getBaseRouter(), $router);

        if (str_starts_with(USER_ACTION_ROUTERS::Create->value, $action) && USER_METHODS_ROUTERS::Create->value == $request->getHeader('REQUEST_METHOD')) {
            $responseGuard = AuthorizationGuard::getInstance()->perform($request, $response);

            if (!$responseGuard->isSuccess()) {
                return $response->send($responseGuard->getResult(), $responseGuard->getStatus());
            }

            return $this->performCreate($request, $response);
        }

        if (str_starts_with(USER_ACTION_ROUTERS::List->value, $action) && USER_METHODS_ROUTERS::List->value == $request->getHeader('REQUEST_METHOD')) {
            return $this->performList($request, $response);
        }

        $res = Result::failure(ErrorModel::getInstance()->setTitle('HTTP Request')->setMessage('Router not found')->addCause('Router ' . $request->getHeader('REQUEST_METHOD') . ' "' . $router . '" not found')->finally(), 404);

        $response->send($res->getResult(), $res->getStatus());
    }

    private function performCreate(Request $request, Response $response)
    {
        $responseData = UserService::getInstance()->create($request->getAllBody());

        return $response->send($responseData->getResult(), $responseData->getStatus());
    }

    private function performList(Request $request, Response $response)
    {
        $responseData = UserService::getInstance()->list($request->getAllBody());

        return $response->send($responseData->getResult(), $responseData->getStatus());
    }

    private function getBaseRouter()
    {
        return PREFIX_CONTROLLERS::User->value;
    }
}
