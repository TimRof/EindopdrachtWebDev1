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
                //$this->redirect('/404');
                var_dump($th);
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
            $user = $userService->login($_POST['email'], $_POST['password']);

            if ($user) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_name'] = $user->name;
                $this->redirect('/login/success');
            } else {
                $_SESSION['POST'] = $_POST['email'];
                $this->redirect('/login');
            }
        } else {
            echo "1";
            $this->redirect('/404');
            die();
        }
    }
}
