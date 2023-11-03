<?php

class AuthAuthorizationUseCase
{
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function perform($data)
    {

        $bearerToken = $data['Authorization'];

        $error = new ErrorModel();
        $error = $error->setTitle('Authorization Admin')->setMessage('Unauthorization Request');

        if (isFalsy($bearerToken)) {
            $error->addCause('You must provide an authorization token');

            return Result::failure($error->getError());
        }
        
        if (count(explode(' ', $bearerToken)) != 2) {
            $error->addCause('Invalid Authorization Token Format');

            return Result::failure($error->getError());
        }

        [$bearar, $token] = explode(' ', $bearerToken);

        if ($bearar !== 'Bearer') {
            $error->addCause('Invalid Authorization Token Format');

            return Result::failure($error->getError());
        }

        $payload = JWT::decode($token, $GLOBALS['SECRET']['key']);

        if (isNull($payload)) {
            $error->addCause('Invalid Authorization Token');

            return Result::failure($error->getError());
        }

        return Result::success($payload);
    }
}
