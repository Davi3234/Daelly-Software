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
        $dto = $this->dealDTO($data);

        if (!$dto->isSuccess()) {
            return $dto;
        }

        $args = $dto->getValue();

        Repository::getInstance()->begin();

        $adm = Repository::getInstance()->find("SELECT * FROM administrador WHERE email = '" . $args->email . "'");

        if (isTruthy($adm)) {
            Repository::getInstance()->rollback();

            return Result::failure(ErrorModel::getInstance()->setTitle('Create Admin')->setMessage('Admin already exists')->addCause('"Email" "' . $args->email . '" is already in use')->finally());
        }

        $passwordHash = md5($args->password);

        $res = Repository::getInstance()->insert("administrador", ['nome' => "'" . $args->username . "'", 'email' => "'" . $args->email . "'", 'senha' => "'" . $passwordHash . "'"]);

        if (!$res) {
            Repository::getInstance()->rollback();

            return Result::failure(ErrorModel::getInstance()->setTitle('Create Admin')->setMessage('Error on create admin')->finally());
        }

        Repository::getInstance()->commit();

        return Result::success('Admin created with successfully');
    }

    private function dealDTO($data)
    {
        $error = ErrorModel::getInstance()->setTitle('Validate args create Admin')->setMessage('Invalid data for creating an admin');

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
            if (!str_ends_with($data['email'], '@gmail.com')) {
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
            return Result::failure($error->finally());
        }

        return Result::success((object) [
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
    }
}
