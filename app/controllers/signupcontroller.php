<?php
require __DIR__ . '/controller.php';
require __DIR__ . '/../services/userservice.php';

class SignUpController extends Controller
{
    public function index()
    {
        try {
            error_reporting(0);
            require __DIR__ . '/../views/signup/index.php';
        } catch (\Throwable $th) {
            $this->redirect('/404');
            die();
        }
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $content = array(
                "name" => $this->clean($_POST['name']),
                "email" => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
                "password" => $this->clean($_POST['password']),
                "password_confirmation" => $this->clean($_POST['password_confirmation'])
            );
            $user = new User($content);
            $userService = new UserService();
            try {
                if ($userService->insert($user)) {
                    $user = $userService->findByEmail($user->getEmail());
                    $_SESSION['user_id'] = $user->id;
                    $_SESSION['user_name'] = $user->name;
                    $this->redirect('/signup/success');
                } else {
                    $this->redirect('/signup/failed');
                }
            } catch (\Throwable $th) {
                $this->redirect('/signup/failed');
            }
        }
    }

    public function success()
    {
        require __DIR__ . '/../views/signup/success.php';
    }
    public function failed()
    {
        require __DIR__ . '/../views/signup/failed.php';
    }
}
