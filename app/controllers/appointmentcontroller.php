<?php
require __DIR__ . '/controller.php';
require __DIR__ . '/../services/appointmentservice.php';

class AppointmentController extends Controller
{
    private $appointmentService;
    function __construct()
    {
        $this->appointmentService = new AppointmentService();
    }
    public function index()
    {
        try {
            $opening = '09:00';
            $closing = '18:00';
            $duration = 45;
            $break = 15;

            $appointments = $this->appointmentService->getTimeslots($opening, $closing, $duration, $break);
            // echo "<pre>";
            // var_dump($appointments);
            // echo "</pre>";
            $this->displayView($appointments);
            //require __DIR__ . '/../views/appointment/index.php';
        } catch (\Throwable $th) {
            http_response_code(404);
            die();
        }
    }
}
