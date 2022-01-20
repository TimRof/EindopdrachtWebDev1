<?php
require __DIR__ . '/../repositories/appointmentrepository.php';

class AppointmentService
{
    public function getAll()
    {
        $repository = new AppointmentRepository();
        return $repository->getAll();
    }
    public function getAllCurrent()
    {
        $repository = new AppointmentRepository();
        return $repository->getAllCurrent();
    }
    public function getAllByDate($date)
    {
        $repository = new AppointmentRepository();
        return $repository->getAllByDate($date);
    }
    public function getAllTypes()
    {
        $repository = new AppointmentRepository();
        return $repository->getAllTypes();
    }
    public function getTimeslots($opening, $closing, $duration, $break)
    {
        date_default_timezone_set('Europe/Amsterdam');
        $timeslots = [];
        $start = clone $opening;
        $closing = clone $closing;
        $end = clone $opening;
        $end->modify("+{$duration} minutes");

        $i = 0;
        do {
            $appointment = new Appointment();
            $appointment->setStart($start);
            $appointment->setEnd(clone $end);
            $appointment->setDuration($duration);
            $appointment->setTimeSlot($i);
            $appointment->setTaken(false);

            $timeslots[$i] = clone $appointment;
            $i++;

            $end->modify("+{$break} minutes");
            $start = clone $end;
            $end->modify("+{$duration} minutes");
        } while ($end <= $closing);

        return $timeslots;
    }
    public function makeAppointment($type, $timeslot, $id)
    {
        $repository = new AppointmentRepository();
        return $repository->makeAppointment($type, $timeslot, $id);
    }
    public function updateAppointment($type, $id)
    {
        $repository = new AppointmentRepository();
        return $repository->updateAppointment($type, $id);
    }
    public function delete($id)
    {
        $repository = new AppointmentRepository();
        return $repository->delete($id);
    }
}
