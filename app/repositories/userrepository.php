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

            $sql = 'INSERT INTO usersbasic (name, contact_mail, password_hash) VALUES (?,?,?)';

            $stmt = $this->connection->prepare($sql);

            return $stmt->execute([$user->getName(), $user->getEmail(), $password_hash]);
        }

        return false;



        // $sql = 'INSERT INTO users (name, first_name, last_name, contact_mail, contact_mobile, birthday, password_hash) VALUES (?,?,?,?,?,?,?)';

        // $stmt = $this->connection->prepare($sql);
        // $stmt->execute([$user->getFirstName(), $user->getLastName(), $user->getContactMail(), $user->getContactMobile, $user->getBirthday, $user->getPasswordHash,]);

    }
    public function validate($user)
    {
        if ($user->getName() == '') {
            $user->errors[] = 'Name is required.';
        }
        if (filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL) === false) {
            $user->errors[] = 'Invalid email.';
        }
        if ($user->password != $user->password_confirmation) {
            $user->errors[] = 'Passwords do not match.';
        }
        if (strlen($user->password) < 6) {
            $user->errors[] = 'Password should be at least 6 characters';
        }
    }
}
