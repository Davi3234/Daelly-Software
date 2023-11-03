<?php

class UserCreateUseCase
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

            $response = $this->performUseCase($data);

            Repository::getInstance()->commit();

            return $response;
        } catch(Exception $e) {
            Repository::getInstance()->rollback();
        }
    }

    private function performUseCase($data) {
        $dto = $this->dealDTO($data);

        if (!$dto->isSuccess()) {
            return $dto;
        }

        $args = $dto->getValue();

        $adm = Repository::getInstance()->find("SELECT * FROM administrador WHERE email = '" . $args->email . "'");

        if (isTruthy($adm)) {
            $err = new ErrorModel();
            return Result::failure($err->setTitle('Create User')->setMessage('User already exists')->addCause('"Email" "' . $args->email . '" is already in use')->getError());
        }

        $passwordHash = md5($args->password);

        $res = Repository::getInstance()->insert("administrador", ['nome' => "'" . $args->username . "'", 'email' => "'" . $args->email . "'", 'senha' => "'" . $passwordHash . "'"]);

        if (!$res) {
            $err = new ErrorModel();
            return Result::failure($err->setTitle('Create User')->setMessage('Error on create user')->getError());
        }

        return Result::success('User created with successfully');
    }

    private function dealDTO($data)
    {
        $error = new ErrorModel();
        $error = $error->setTitle('Validate args create User')->setMessage('Invalid data for creating an user');

        if (!array_key_exists('username', $data) || isFalsy($data['username'])) {
            $error->addCause('"Username" is required');
        } else {
            $data['username'] = trim($data['username']);
            if (strlen($data['username']) < 3) {
                $error->addCause('"Username" must be longer than 3 digits');
            }
        }

        if (!array_key_exists('email', $data) || isFalsy($data['email'])) {
            $error->addCause('"Email" is required');
        } else {
            $data['email'] = trim($data['email']);
            if (!isEndsWith('@gmail.com', $data['email'])) {
                $error->addCause('Format "Email" invalid');
            }
        }

        if (!array_key_exists('password', $data) || isFalsy($data['password'])) {
            $error->addCause('"Password" is required');
        } else {
            $data['password'] = trim($data['password']);
            if (strlen($data['password']) < 6 || strlen($data['password']) > 15) {
                $error->addCause('"Password" must contain between 6 and 15 digits');
            }
        }

        if (isTruthy($error->getCauses())) {
            return Result::failure($error->getError());
        }

        return Result::success((object) [
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
    }
}
