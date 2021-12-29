<?php
require __DIR__ . '/../../services/appointmentservice.php';

class AppointmentController
{

    private $appointmentService;

    // initialize services
    function __construct()
    {
        header("Content-type:application/json");
        $this->appointmentService = new AppointmentService();
    }

    public function index()
    {

        // your code here
        // return all appointments in the database as JSON
        header("Content-type:application/json");
        echo json_encode($this->appointmentService->getAll());
    }
}
