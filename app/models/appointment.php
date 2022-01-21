<?php
require __DIR__ . '/../models/user.php';

class Appointment implements \JsonSerializable
{
    private $id;
    private $user_id;
    private $type;
    private $timeslot;
    private $starttime;
    private $endtime;
    private $duration;
    private $booked;
    private $taken;

    public $errors = [];

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }
    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }
    public function getTimeSlot(): int
    {
        return $this->timeslot;
    }
    public function setTimeSlot(int $timeslot): self
    {
        $this->timeslot = $timeslot;

        return $this;
    }
    public function getStart(): DateTime
    {
        return $this->starttime;
    }
    public function setStart(DateTime $starttime): self
    {
        $this->starttime = $starttime;

        return $this;
    }
    public function getEnd(): DateTime
    {
        return $this->endtime;
    }
    public function setEnd(DateTime $endtime): self
    {
        $this->endtime = $endtime;

        return $this;
    }
    public function getType(): string
    {
        return $this->type;
    }
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
    public function getTaken(): bool
    {
        return $this->taken;
    }
    public function setTaken(bool $taken): self
    {
        $this->taken = $taken;

        return $this;
    }
    public function getUser_id(): int
    {
        return $this->user_id;
    }
    public function setUser_id(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
