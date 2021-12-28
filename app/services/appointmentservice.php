<?php
require __DIR__ . '/../repositories/appointmentrepository.php';

class AppointmentService
{
    public function getTimeslots($opening, $closing, $duration, $break)
    {
        error_reporting(1);
        date_default_timezone_set('Europe/Amsterdam');
        $timeslots = [];
        $start = new DateTime($opening);
        $closing = new DateTime($closing);
        $end = new DateTime($opening);
        $end->modify("+{$duration} minutes");

        $i = 0;
        do {
            $appointment = new Appointment();
            $appointment->setStart(clone $start);
            $appointment->setEnd(clone $end);

            $i++;
            $timeslots[$i] = $appointment;

            $end->modify("+{$break} minutes");
            $start = clone $end;
            $end->modify("+{$duration} minutes");
        } while ($end <= $closing);

        return $timeslots;
    }
}
