<?php

class User implements \JsonSerializable
{
    private int $id;
    private string $name;
    private string $email;

    public $errors = [];

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
