<?php
require __DIR__ . '/controller.php';

class LoginController extends Controller
{
    public function index()
    {
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
    }
}
