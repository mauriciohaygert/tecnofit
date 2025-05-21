<?php

namespace App\Controller;

use App\Model\Repository\MovementRepository;
use App\Model\Repository\PersonalRecordRepository;
use League\Route\Http\Exception\BadRequestException;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MovementController
{
    public function __construct(
        public MovementRepository       $movements,
        public PersonalRecordRepository $personalRecords,
        public Response                 $response
    )
    {
    }

    public function rankingMovementAction(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $movementId = $args['movementId'] ?? 0;
        $movementName = $args['movementName'] ?? '';

        $movement = $this->movements->find($movementId, $movementName);
        if (!$movement) {
            throw new BadRequestException('Movement not found');
        }

        $ranking = $this->ranking($this->personalRecords->userRankByMovement($movement->id));

        $this->jsonResponse([
            'movement' => $movement->name,
            'ranking' => $ranking
        ]);

        return $this->response->withStatus(201);
    }

    public function ranking(array $ranking): array
    {
        $ranked = [];
        $lastRecord = 0;
        $currentRank = 0;

        foreach ($ranking as $record) {
            if ($record['record'] !== $lastRecord) {
                $lastRecord = $record['record'];
                $currentRank++;
            }
            $ranked[] = [
                'user' => $record['user'],
                'record' => (float)$record['record'],
                'rank' => $currentRank,
                'date' => date('d-m-Y', strtotime($record['date']))
            ];
        }
        return $ranked;
    }

    public function jsonResponse(array $response)
    {
        $this->response->getBody()->write(json_encode($response, JSON_PRETTY_PRINT));
    }
}
