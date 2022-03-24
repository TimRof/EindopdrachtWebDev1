<?php
require __DIR__ . '/controller.php';
require __DIR__ . '/../services/userservice.php';


class AccountController extends Controller
{
    public function validateEmail()
    {
        $userservice = new UserService();
        $isValid = $userservice->validateEmail(filter_var($_GET['email'], FILTER_SANITIZE_EMAIL));
        header('Content-Type: application/json');
        echo json_encode($isValid);
    }
}
