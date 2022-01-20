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
                $types = $this->appointmentService->getAllTypes();
                $this->displayView($types);
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
    public function getTaken()
    {
        header("Content-type:application/json");
        $this->appointmentService = new AppointmentService();
        echo json_encode($this->appointmentService->getAllCurrent(), JSON_PRETTY_PRINT);
    }
    public function getSlotsByDate($data)
    {
        $date = new DateTime($data);
        $opening = clone $date;
        $opening->setTime(9, 0, 0);
        $closing = clone $date;
        $closing->setTime(18, 0, 0);
        $duration = 45;
        $break = 15;

        $taken = $this->appointmentService->getAllByDate($date);
        $timeslots = $this->appointmentService->getTimeslots($opening, $closing, $duration, $break);
        foreach ($timeslots as $slot1) {
            foreach ($taken as $slot2) {
                if ($slot1->getTimeSlot() == $slot2->getTimeSlot()) {
                    $slot1->setTaken(1);
                    break;
                } else {
                    $slot1->setTaken(0);
                }
            }
        }

        return $timeslots;
    }
    public function api()
    {
        if (isset($_SESSION['admin'])) {
            header("Content-type:application/json");
            $this->appointmentService = new AppointmentService();
            echo json_encode($this->appointmentService->getAllCurrent(), JSON_PRETTY_PRINT);
        }
    }
    public function getFreeSlots()
    {
        $taken = $this->getSlotsByDate($_POST['date']);
        header("Content-type:application/json");
        echo json_encode(($taken), JSON_PRETTY_PRINT);
    }
    public function getTypes()
    {
        $types = $this->appointmentService->getAllTypes();
        header("Content-type:application/json");
        echo json_encode(($types), JSON_PRETTY_PRINT);
    }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $types = $this->appointmentService->getAllTypes();
            $timeslots = $this->getSlotsByDate($_POST['hiddendate']);

            foreach ($timeslots as $s) {
                if ($s->getTimeSlot() == $_POST['time-options']) {
                    $timeslot = clone $s;
                }
            }
            foreach ($types as $t) {
                if ($t->getId() == $_POST['type-options']) {
                    $type = clone $t;
                }
            }
            $id = $_SESSION['user_id'];
            $this->appointmentService = new AppointmentService();
            try {
                if ($this->appointmentService->makeAppointment($type, $timeslot, $id)) {
                    $this->redirect('/appointment/success');
                } else {
                    $this->redirect('/appointment/failed');
                }
            } catch (\Throwable $th) {
                $this->redirect('/appointment/failed');
            }
        }
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $type = $_POST['type'];
            $this->appointmentService = new AppointmentService();
            $this->appointmentService->updateAppointment($type, $id);
        }
    }
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            var_dump($_POST);
            $this->appointmentService->delete($_POST['id']);
        }
    }
    public function success()
    {
        require __DIR__ . '/../views/appointment/success.php';
    }
    public function failed()
    {
        require __DIR__ . '/../views/appointment/failed.php';
    }
}
