<?php

namespace App\Model;

use DateTime;

class PersonalRecord
{
    public int $id;

    public function __construct(
        private int      $userID,
        private int      $movementId,
        private float    $value,
        private string   $date
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getMovementId(): int
    {
        return $this->movementId;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getUserID(): int
    {
        return $this->userID;
    }


}