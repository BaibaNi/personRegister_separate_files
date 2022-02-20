<?php
class Person
{
    private string $name;
    private string $surname;
    private string $code;


    public function __construct(string $name, string $surname, string $code)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->code = $code;
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function getSurname(): string
    {
        return $this->surname;
    }


    public function getCode(): string
    {
        return $this->code;
    }
}