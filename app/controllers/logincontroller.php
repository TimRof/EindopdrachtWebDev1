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
            $this->redirect('/404');
            die();
        }
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userService = new UserService();
            $user = $userService->login($_POST['email'], $_POST['password']);
            if ($user) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_name'] = $user->name;
                $_SESSION['admin'] = $user->admin;
                $this->redirect('/login/success');
            } else {
                $_SESSION['POST'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $this->redirect('/login');
            }
        } else {
            $this->redirect('/404');
            die();
        }
    }
    public function success()
    {
        if (isset($_SESSION['user_id'])) {
            require __DIR__ . '/../views/login/success.php';
        } else {
            $this->redirect('/404');
            die();
        }
    }
}
