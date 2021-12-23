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
            http_response_code(404);
            die();
        }
    }

    public function create()
    {
        $user = new User($_POST);
        $userservice = new UserService();
        // echo '<pre>';
        // var_dump($user);
        // echo "<br><br>";
        // var_dump($_POST);
        try {
            if ($userservice->insert($user)) {
                $this->redirect('/signup/success');
            } else {
                $this->redirect('/signup/failed');
            }
        } catch (\Throwable $th) {
            echo "<br> <br> catchsignup";
            echo '<pre>';
            echo $th;
            var_dump($user);
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
