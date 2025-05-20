<?php

namespace App\Model;

class Movement
{
    public readonly int $id;
    public function __construct(public string $name)
    {

    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}