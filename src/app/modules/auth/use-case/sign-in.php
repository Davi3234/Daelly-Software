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
        $dto = $this->dealDTO($data);

        if (!$dto->isSuccess()) {
            return $dto;
        }

        $args = $dto->getValue();

        Repository::getInstance()->begin();

        $adm = Repository::getInstance()->find("SELECT * FROM administrador WHERE email = '" . $args->email . "'");

        if (isFalsy($adm)) {
            Repository::getInstance()->rollback();

            $error = new ErrorModel();
            return Result::failure($error->setTitle('Sign-in Admin')->setMessage('Cannot sign-in admin')->addCause('Email or password invalid')->getError());
        }

        if ($adm['senha'] != md5($args->password)) {
            Repository::getInstance()->rollback();

            $error = new ErrorModel();
            return Result::failure($error->setTitle('Sign-in Admin')->setMessage('Cannot sign-in admin')->addCause('Email or password invalid')->getError());
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
        $error = $error->setTitle('Validate args sign-in Admin')->setMessage('Invalid data for sign-in admin');

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
            return Result::failure($error->getError());
        }

        return Result::success((object) [
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
    }
}
