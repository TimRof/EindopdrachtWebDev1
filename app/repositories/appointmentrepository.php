<?php

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
    function getAllByDate($selectedDate)
    {
        $dayAfter = clone $selectedDate;
        $dayAfter->modify('+1 day');
        $sql = 'SELECT * FROM appointments WHERE start >= :selectedDate AND start < :dayAfter';

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
            $sql = 'INSERT INTO appointments (user_id, start, end, type) VALUES (:user_id, :start, :end, :type)';
            $stmt = $this->connection->prepare($sql);

            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
            $stmt->bindValue(':start', $appointment->getStart(), PDO::PARAM_STR);
            $stmt->bindValue(':end', $appointment->getEnd(), PDO::PARAM_STR);
            $stmt->bindValue(':type', $appointment->getType(), PDO::PARAM_STR);

            return $stmt->execute();
        }
        return false;
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
}
