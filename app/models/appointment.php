<?php
require __DIR__ . '/../models/user.php';


class Appointment implements \JsonSerializable
{
    private $user;
    private $type;
    private $start;
    private $end;
    private $duration;
    private $booked;
    private $available;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
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
    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
