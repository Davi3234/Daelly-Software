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
        $error = $error->setTitle('Authorization User')->setMessage('Unauthorization Request');

        if (isFalsy($bearerToken)) {
            $error->addCause('You must provide an authorization token');

            return Result::failure($error);
        }
        
        if (count(explode(' ', $bearerToken)) != 2) {
            $error->addCause('Invalid Authorization Token Format');

            return Result::failure($error);
        }

        [$bearar, $token] = explode(' ', $bearerToken);

        if ($bearar !== 'Bearer') {
            $error->addCause('Invalid Authorization Token Format');

            return Result::failure($error);
        }

        $payload = JWT::decode($token, $GLOBALS['SECRET']['key']);

        if (isNull($payload)) {
            $error->addCause('Invalid Authorization Token');

            return Result::failure($error);
        }

        return Result::success($payload);
    }
}
