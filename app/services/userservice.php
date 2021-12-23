<?php
require __DIR__ . '/../repositories/userrepository.php';

class UserService
{
    public function getAll()
    {
        $repository = new UserRepository();
        $users = $repository->getAll();
        return $users;
    }

    public function insert($user)
    {
        $repository = new UserRepository();
        return $repository->insert($user);
    }
}
