<?php
require __DIR__ . '/controller.php';
require __DIR__ . '/../services/userservice.php';


class AccountController extends Controller
{
    public function validateEmail()
    {
        // check if post, then check 
        $userservice = new UserService();
        $isValid = $userservice->validateEmail($_GET['email']);
        header('Content-Type: application/json');
        echo json_encode($isValid);
    }
}
