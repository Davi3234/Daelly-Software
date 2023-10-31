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

        $adm = Repository::getInstance()->query("SELECT * FROM administrador WHERE email = '" . $args['email'] . "'");

        if (isTruthy($adm)) {
            Repository::getInstance()->rollback();

            return Result::failure(ErrorModel::getInstance()->setTitle('Create Admin')->setMessage('Admin already exists')->addCause('"Email" "' . $args['email'] . '" is already in use')->finally());
        }

        $res = Repository::getInstance()->exec("INSERT INTO administrador (nome, email, senha, tentativas, ultimo_acesso) VALUES ('" . $args['username'] .  "', '" . $args['email'] .  "', '" . md5($args['password']) .  "', 0, '2023-10-30 10:00:00')");

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
            if (strlen($data['username']) > 3) {
                $error->addCause('"Username" must be longer than 3 digits');
            }
        }

        if (!array_key_exists('email', $data) || isFalsy($data['email'])) {
            $error->addCause('"Email" is required');
        } else {
            if (str_ends_with('@gmail.com', $data['email'])) {
                $error->addCause('Format "Email" invalid');
            }
        }

        if (!array_key_exists('password', $data) || isFalsy($data['password'])) {
            $error->addCause('"Password" is required');
        } else {
            if (strlen($data['password']) < 6 || strlen($data['password']) > 15) {
                $error->addCause('"Password" must contain between 6 and 15 digits');
            }
        }

        if (isTruthy($error->getCauses())) {
            return Result::failure($error->finally());
        }

        return Result::success($data);
    }
}
