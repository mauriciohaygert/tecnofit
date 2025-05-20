<?php

namespace App\Model\Repository;

use PDO;

class UserRepository
{
    public function __construct(private PDO $pdo)
    {
    }

}