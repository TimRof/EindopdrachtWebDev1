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
        if (isset($_SESSION['user_id'])) {
            try {
                $timeslots = $this->getSlots();
                $this->displayView($timeslots);
            } catch (\Throwable $th) {
                $this->redirect('/404');
                die();
            }
        } else {
            require __DIR__ . '/../views/error/forbidden.php';
        }
    }
    public function getSlots()
    {
        $date = new DateTime();
        $opening = clone $date;
        $opening->setTime(9, 0, 0);
        $closing = clone $date;
        $closing->setTime(18, 0, 0);
        $duration = 45;
        $break = 15;

        $taken = $this->appointmentService->getAll();
        $timeslots = $this->appointmentService->getTimeslots($opening, $closing, $duration, $break);

        foreach ($timeslots as $slot1) {
            foreach ($taken as $slot2) {
                if ($slot1->getTimeSlot() == $slot2->getTimeSlot()) {
                    $slot1->setTaken(1);
                } else {
                    $slot1->setTaken(0);
                }
            }
        }

        return $timeslots;
    }
    public function getSlotsByDate($data)
    {
        try {
            $date = new DateTime($data);
        } catch (\Throwable $th) {
            $date = $data;
        }
        $opening = clone $date;
        $opening->setTime(9, 0, 0);
        $closing = clone $date;
        $closing->setTime(18, 0, 0);
        $duration = 45;
        $break = 15;

        $taken = $this->appointmentService->getAllByDate($date);
        $timeslots = $this->appointmentService->getTimeslots($opening, $closing, $duration, $break);
        foreach ($timeslots as $slot1) {
            if ($taken) {
                foreach ($taken as $slot2) {
                    if ($slot1->getTimeSlot() == $slot2->getTimeSlot()) {
                        $slot1->setTaken(1);
                    } else {
                        $slot1->setTaken(0);
                    }
                }
            } else {
                $slot1->setTaken(0);
            }
        }

        return $timeslots;
    }
    public function api()
    {
        header("Content-type:application/json");
        $this->appointmentService = new AppointmentService();
        echo json_encode($this->getSlots(), JSON_PRETTY_PRINT);
    }
    public function getFreeSlots()
    {
        $taken = $this->getSlotsByDate($_POST['date']);
        header("Content-type:application/json");
        echo json_encode(($taken), JSON_PRETTY_PRINT);
    }
    public function test()
    {
        $taken = $this->getSlotsByDate($_POST['date']);
        // echo '<pre>';
        // var_dump($taken);
        header("Content-type:application/json");
        echo json_encode(($taken), JSON_PRETTY_PRINT);
    }
}
