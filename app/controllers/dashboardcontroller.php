<?php
require __DIR__ . '/controller.php';
require __DIR__ . '/../services/userservice.php';

class DashboardController extends Controller
{
    public function index()
    {
        if (isset($_SESSION['admin'])) {
            try {
                error_reporting(0);
                require __DIR__ . '/../views/dashboard/index.php';
            } catch (\Throwable $th) {
                $this->redirect('/404');
                die();
            }
        } else {
            $this->redirect('/404');
            die();
        }
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userService = new UserService();
            $user = $userService->login(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL), $_POST['password']);

            if ($user) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_name'] = $user->name;
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
}
