<?php

class AuthorizationGuard implements Guard {
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function perform(Request $request, Response $response) {
        $bearerToken = $request->getHeader('HTTP_AUTHORIZATION');

        $error = ErrorModel::getInstance()->setTitle('Authorization Admin')->setMessage('Unauthorization Request');
        
        if (isFalsy($bearerToken)) {
            $error->addCause('You must provide an authorization token');
            
            return Result::failure($error->finally());
        }
        
        if (count(explode(' ', $bearerToken)) != 2) {
            $error->addCause('Invalid Authorization Token Format');

            return Result::failure($error->finally());
        }

        [$bearar, $token] = explode(' ', $bearerToken);

        if ($bearar !== 'Bearer') {
            $error->addCause('Invalid Authorization Token Format');

            return Result::failure($error->finally());
        }

        $payload = JWT::decode($token, $GLOBALS['SECRET']['key']);

        if (isNull($payload)) {
            $error->addCause('Invalid Authorization Token');

            return Result::failure($error->finally());
        }

        return Result::success(true);
    }
}