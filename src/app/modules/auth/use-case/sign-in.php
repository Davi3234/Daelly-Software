<?php

class AuthSignInUseCase
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
        try {
            Repository::getInstance()->begin();

            $res = $this->performUseCase($data);

            Repository::getInstance()->commit();

            return $res;
        } catch(Exception | ResultException $e) {
            Repository::getInstance()->rollback();

            if ($e instanceof ResultException) {
                return Result::failure($e, $e->getCode());
            }
            
            $err = new ResultModel();
            return Result::failure($err->setMessage($e->getMessage()));
        }
    }

    function performUseCase($data) {
        $dto = $this->dealDTO($data);

        $args = $dto->getValue();

        $adm = Repository::getInstance()->find("SELECT * FROM administrador WHERE email = '" . $args->email . "'");

        if (isFalsy($adm)) {
            $error = new ErrorModel();
            return Result::failure($error->setTitle('Sign-in User')->setMessage('Cannot sign-in user')->addCause('Email or password invalid'));
        }

        if ($adm['senha'] != md5($args->password)) {
            $error = new ErrorModel();
            return Result::failure($error->setTitle('Sign-in User')->setMessage('Cannot sign-in user')->addCause('Email or password invalid'));
        }

        $payload = [
            'sub' => $adm['id'],
            'email' => $adm['email'],
        ];

        $token = JWT::encode($payload, ['secret' => $GLOBALS['SECRET']['key'], 'expire' => $GLOBALS['SECRET']['expire-token']]);

        return Result::success(['token' => $token]);
    }

    private function dealDTO($data) {
        $error = new ErrorModel();
        $error = $error->setTitle('Validate args sign-in User')->setMessage('Invalid data for sign-in user');

        if (!array_key_exists('email', $data) || isFalsy($data['email'])) {
            $error->addCause('"Email" is required');
        } else {
            $data['email'] = trim($data['email']);
        }

        if (!array_key_exists('password', $data) || isFalsy($data['password'])) {
            $error->addCause('"Password" is required');
        } else {
            $data['password'] = trim($data['password']);
        }

        if (isTruthy($error->getCauses())) {
            throw new ResultException($error);
        }

        return Result::success((object) [
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
    }
}
