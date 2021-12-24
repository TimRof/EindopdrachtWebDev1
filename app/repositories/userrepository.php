<?php

require __DIR__ . '/repository.php';
require __DIR__ . '/../models/user.php';

class UserRepository extends Repository
{
    public $errors = [];
    public function getAll()
    {
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
        $sql = 'SELECT * FROM usersbasic WHERE email = :email';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch() !== false;
    }
}
