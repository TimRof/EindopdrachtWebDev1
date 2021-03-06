<?php

require __DIR__ . '/repository.php';
require __DIR__ . '/../models/user.php';

class UserRepository extends Repository
{
    public $errors = [];
    public function getAll()
    {
        $sql = 'SELECT id, name FROM usersbasic';

        $stmt = $this->connection->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'user');

        $stmt->execute();

        return $stmt->fetchAll();
    }
    public function insert($user)
    {
        $this->validate($user);
        if (empty($user->errors)) {
            $password_hash = password_hash($user->password, PASSWORD_DEFAULT);
            $sql = 'INSERT INTO usersbasic (name, email, password_hash) VALUES (:name, :email, :password_hash)';
            $stmt = $this->connection->prepare($sql);

            $stmt->bindValue(':name', $user->getName(), PDO::PARAM_STR);
            $stmt->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
            $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);

            return $stmt->execute();
        }

        return false;
    }
    protected function validate($user)
    {
        // name
        if ($user->getName() == '') {
            $user->errors[] = 'Name is required.';
        }

        // email address
        if (filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL) === false) {
            $user->errors[] = 'Invalid email.';
        }
        if ($this->emailExists($user->getEmail())) {
            $user->errors[] = 'Email is already taken';
        }

        // password
        if ($user->password != $user->password_confirmation) {
            $user->errors[] = 'Passwords do not match.';
        }
        if (strlen($user->password) < 6) {
            $user->errors[] = 'Password should be at least 6 characters';
        }
    }
    public function emailExists($email)
    {
        return $this->findByEmail($email) !== false;
    }
    public function findByEmail($email)
    {
        $sql = 'SELECT * FROM usersbasic WHERE email = :email';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }
    public function checkCredentials($email, $password)
    {
        $user = $this->findByEmail($email);

        if ($user) {
            if (password_verify($password, $user->password_hash)) {
                return $user;
            }
        }

        return false;
    }
}
