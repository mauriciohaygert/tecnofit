<?php

namespace App\Model\Repository;

use App\Model\PersonalRecord;
use PDO;

class PersonalRecordRepository
{
    public function __construct(private PDO $pdo)
    {
    }

     public function userRankByMovement($movementId)
    {
        $statement = $this->pdo->prepare(
            "SELECT user.name AS user, MAX(personal_record.value) AS record, 
            MAX(personal_record.date) AS date
            FROM personal_record
            JOIN user ON user.id = personal_record.user_id
            WHERE movement_id = :movementId
            GROUP BY user.id
            ORDER BY record DESC, date ASC");
        $statement->bindValue('movementId', $movementId, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}
