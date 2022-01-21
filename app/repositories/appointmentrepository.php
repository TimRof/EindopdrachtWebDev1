<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require __DIR__ . '/../repositories/repository.php';
require __DIR__ . '/../models/appointment.php';
require __DIR__ . '/../models/type.php';

class AppointmentRepository extends Repository
{
    private $errors = [];
    function getAll()
    {
        $sql = 'SELECT * FROM appointments';

        $stmt = $this->connection->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'appointment');

        $stmt->execute();

        return $stmt->fetchAll();
    }
    function getAllCurrent()
    {
        $sql = 'SELECT appointments.id, user_id, timeslot, starttime, endtime, type, usersbasic.name, usersbasic.email FROM appointments INNER JOIN usersbasic ON appointments.user_id = usersbasic.id WHERE starttime
        >= :currentDate';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':currentDate', date('Y-m-d H:i:s', strtotime('-1 hour')), PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'appointment');

        $stmt->execute();

        return $stmt->fetchAll();
    }
    function getAllByDate($selectedDate)
    {
        $dayAfter = clone $selectedDate;
        $dayAfter->setTime(23, 59, 59);
        $selectedDate->setTime(8, 0, 0);

        $sql = 'SELECT * FROM appointments WHERE starttime >= :selectedDate AND starttime < :dayAfter';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':selectedDate', date_format($selectedDate, 'Y-m-d H:i:s'), PDO::PARAM_STR);
        $stmt->bindValue(':dayAfter', date_format($dayAfter, 'Y-m-d H:i:s'), PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'appointment');

        $stmt->execute();

        return $stmt->fetchAll();
    }
    public function insert($appointment, $user_id)
    {
        $this->validate($appointment);
        if (empty($appointment->errors)) {
            $sql = 'INSERT INTO appointments (user_id, starttime, endtime, type) VALUES (:user_id, :starttime, :endtime, :type)';
            $stmt = $this->connection->prepare($sql);

            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
            $stmt->bindValue(':starttime', $appointment->getStart(), PDO::PARAM_STR);
            $stmt->bindValue(':endtime', $appointment->getEnd(), PDO::PARAM_STR);
            $stmt->bindValue(':type', $appointment->getType(), PDO::PARAM_STR);
            var_dump($stmt);

            return $stmt->execute();
        }
        return false;
    }
    public function delete($id)
    {
        $sql = 'DELETE FROM appointments WHERE appointments.id = :id';
        $stmt = $this->connection->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_STR);

        return $stmt->execute();
    }
    private function validate($appointment)
    {
        // check taken
        if ($appointment->getTaken()) {
            $appointment->errors[] = 'Timeslot is already taken';
        }
        // check date
        if (date_format($appointment->getStart(), 'Y-m-d H:i:s') < date('Y-m-d H:i:s')) {
            $appointment->errors[] = 'Can not book in the past';
        }
    }
    public function getAllTypes()
    {
        $sql = 'SELECT * FROM types';

        $stmt = $this->connection->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'type');

        $stmt->execute();

        return $stmt->fetchAll();
    }
    public function makeAppointment($type, $timeslot, $id)
    {
        $this->validate($timeslot);
        if (empty($timeslot->errors)) {
            $sql = 'INSERT INTO appointments (user_id, timeslot, starttime, endtime, type) VALUES (:user_id, :timeslot, :starttime, :endtime, :type)';
            $stmt = $this->connection->prepare($sql);

            $stmt->bindValue(':user_id', $id, PDO::PARAM_STR);
            $stmt->bindValue(':timeslot', $timeslot->getTimeSlot(), PDO::PARAM_STR);
            $stmt->bindValue(':starttime', date_format($timeslot->getStart(), 'Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindValue(':endtime', date_format($timeslot->getEnd(), 'Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindValue(':type', $type->type, PDO::PARAM_STR);

            return $stmt->execute();
        }

        return false;
    }
    public function updateAppointment($type, $id)
    {
        $sql = 'UPDATE appointments
        INNER JOIN types
        ON types.id = :type
        SET appointments.type = types.type
        WHERE appointments.id = :id';
        $stmt = $this->connection->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_STR);
        $stmt->bindValue(':type', $type, PDO::PARAM_STR);

        return $stmt->execute();
    }
}
