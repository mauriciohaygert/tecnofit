<?php

namespace App\Model\Repository;

use App\Model\Movement;
use PDO;

class MovementRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function find(int $id = 0, string $name = "") : Movement|null
    {
        $statement = $this->pdo->prepare('SELECT * FROM movement WHERE id = ? OR name = ? LIMIT 1;');
        $statement->bindValue(1, $id, \PDO::PARAM_INT);
        $statement->bindValue(2, $name, \PDO::PARAM_STR);
        $statement->execute();

        $movement = $statement->fetch(\PDO::FETCH_ASSOC);
        if (!$movement) {
            return null;
        }
        return $this->loadMovement($movement);
    }

    private function loadMovement(array $movementData): Movement
    {
        $movement = new Movement($movementData['name']);
        $movement->setId($movementData['id']);

        return $movement;
    }

}