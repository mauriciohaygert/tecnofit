<?php

namespace App\Model\Repository;

use PDO;

class PersonalRecordRepository
{
    public function __construct(private PDO $pdo)
    {
    }
    public function all(): array
    {
        $videoList = $this->pdo
            ->query('SELECT * FROM videos;')
            ->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(
            $this->hydrateVideo(...),
            $videoList
        );
    }

    public function find(int $id)
    {
        $statement = $this->pdo->prepare('SELECT * FROM videos WHERE id = ?;');
        $statement->bindValue(1, $id, \PDO::PARAM_INT);
        $statement->execute();

        return $this->hydrateVideo($statement->fetch(\PDO::FETCH_ASSOC));
    }

}