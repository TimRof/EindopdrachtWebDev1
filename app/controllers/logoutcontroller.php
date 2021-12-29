<?php
require __DIR__ . '/controller.php';
require __DIR__ . '/../services/userservice.php';

class LogoutController extends Controller
{
    public function index()
    {
        try {
            error_reporting(0);
            $_SESSION = array();
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(
                    session_name(),
                    '',
                    time() - 42000,
                    $params["path"],
                    $params["domain"],
                    $params["secure"],
                    $params["httponly"]
                );
            }
            session_destroy();
            require __DIR__ . '/../views/logout/success.php';
        } catch (\Throwable $th) {
            $this->redirect('/404');
            die();
        }
    }
    public function logout()
    {
        require __DIR__ . '/../views/logout/success.php';
    }
}
