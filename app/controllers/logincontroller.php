<?php
require __DIR__ . '/controller.php';
require __DIR__ . '/../services/userservice.php';

class LoginController extends Controller
{
    public function index()
    {
        try {
            error_reporting(0);
            $email = $_SESSION['POST'];
            unset($_SESSION['POST']);
        } catch (\Throwable $th) {
            //ignore
        }


        try {
            error_reporting(0);
            require __DIR__ . '/../views/login/index.php';
        } catch (\Throwable $th) {
            http_response_code(404);
            die();
        }
    }

    public function create()
    {
        $userService = new UserService();
        $user = $userService->login($_POST['email'], $_POST['password']);

        if ($user) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->name;
            $this->redirect('/login/success');
        } else {
            $_SESSION['POST'] = $_POST['email'];
            $this->redirect('/login');
        }
    }
    public function success()
    {
        require __DIR__ . '/../views/login/success.php';
    }
}
