<?php
require __DIR__ . '/controller.php';

class PageNotFoundController extends Controller
{
    public function index()
    {
        try {
            error_reporting(0);
            require __DIR__ . '/views/error/index.php';
            die();
        } catch (\Throwable $th) {
            http_response_code(404);
            die();
        }
    }
}
