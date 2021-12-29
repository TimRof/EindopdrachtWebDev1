<?php
require __DIR__ . '/../models/user.php';

class Appointment implements \JsonSerializable
{
    private $id;
    private $user_id;
    private $type;
    private $timeslot;
    private $start;
    private $end;
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
        return $this->start;
    }
    public function setStart(DateTime $start): self
    {
        $this->start = $start;

        return $this;
    }
    public function getEnd(): DateTime
    {
        return $this->end;
    }
    public function setEnd(DateTime $end): self
    {
        $this->end = $end;

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
    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
