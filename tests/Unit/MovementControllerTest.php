<?php

namespace Tests\Unit;

use App\Model\Movement;
use PHPUnit\Framework\TestCase;
use App\Controller\MovementController;
use App\Model\Repository\MovementRepository;
use App\Model\Repository\PersonalRecordRepository;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;

class MovementControllerTest extends TestCase
{
    public function testRankingMovementActionReturns201WithValidData()
    {
        $movementId = 1;
        $movementName = 'Squat';

        $movement = new Movement($movementName);
        $movement->setId($movementId);

        $rankingData = $this->getRankingInputData();

        $request = $this->createMock(ServerRequestInterface::class);

        $movementRepository = $this->createMock(MovementRepository::class);
        $movementRepository->method('find')
            ->with($movementId, $movementName)
            ->willReturn($movement);

        $personalRecordRepository = $this->createMock(PersonalRecordRepository::class);
        $personalRecordRepository->method('userRankByMovement')
            ->with($movementId)
            ->willReturn($rankingData);

        $response = new Response();

        $controller = new MovementController(
            $movementRepository,
            $personalRecordRepository,
            $response
        );

        $args = ['movementId' => $movementId, 'movementName' => $movementName];
        $result = $controller->rankingMovementAction($request, $args);

        $this->assertEquals(201, $result->getStatusCode());

        $body = (string)$result->getBody();
        $json = json_decode($body, true);

        $this->assertEquals($movementName, $json['movement']);
        $this->assertCount(4, $json['ranking']);
        $this->assertEquals('Mauricio', $json['ranking'][0]['user']);
        $this->assertEquals(1, $json['ranking'][0]['rank']);
    }

    public function testRankingMovementActionThrowsExceptionIfMovementNotFound()
    {
        $this->expectException(\League\Route\Http\Exception\BadRequestException::class);

        $movementRepository = $this->createMock(MovementRepository::class);
        $movementRepository->method('find')
            ->willReturn(null);

        $personalRecordRepository = $this->createMock(PersonalRecordRepository::class);
        $response = new Response();
        $request = $this->createMock(ServerRequestInterface::class);

        $controller = new MovementController(
            $movementRepository,
            $personalRecordRepository,
            $response
        );

        $args = ['movementId' => 777, 'movementName' => 'any'];
        $controller->rankingMovementAction($request, $args);
    }

    public function testRankingGeneratesCorrectRankingOrder()
    {
        $rankingData = $this->getRankingInputData();
        $expected = $this->getExpectedRankingResult();

        $movementRepo = $this->createMock(MovementRepository::class);
        $personalRecordRepo = $this->createMock(PersonalRecordRepository::class);
        $response = new Response();

        $controller = new MovementController($movementRepo, $personalRecordRepo, $response);

        $result = $controller->ranking($rankingData);

        $this->assertCount(4, $result);
        $this->assertEquals(1, $result[0]['rank']);
        $this->assertEquals(1, $result[1]['rank']);
        $this->assertEquals(2, $result[2]['rank']);
        $this->assertEquals(3, $result[3]['rank']);

        foreach ($result as $i => $item) {
            $this->assertEquals($expected[$i]['user'], $item['user']);
            $this->assertEquals($expected[$i]['record'], $item['record']);
            $this->assertEquals($expected[$i]['rank'], $item['rank']);
            $this->assertEquals($expected[$i]['date'], $item['date']);
            $this->assertMatchesRegularExpression('/\d{2}-\d{2}-\d{4}/', $item['date']);
        }
    }


    private
    function getExpectedRankingResult(): array
    {
        return [
            [
                'user' => 'Mauricio',
                'record' => 150.0,
                'rank' => 1,
                'date' => '01-05-2025'
            ],
            [
                'user' => 'Leticia',
                'record' => 150.0,
                'rank' => 1,
                'date' => '28-02-2025'
            ],
            [
                'user' => 'Fabiano',
                'record' => 140.0,
                'rank' => 2,
                'date' => '03-05-2025'
            ],
            [
                'user' => 'Rafael',
                'record' => 130.0,
                'rank' => 3,
                'date' => '30-04-2025'
            ]
        ];
    }

    private
    function getRankingInputData(): array
    {
        return [
            ['user' => 'Mauricio', 'record' => 150.0, 'date' => '2025-05-01'],
            ['user' => 'Leticia', 'record' => 150.0, 'date' => '2025-02-28'],
            ['user' => 'Fabiano', 'record' => 140.0, 'date' => '2025-05-03'],
            ['user' => 'Rafael', 'record' => 130.0, 'date' => '2025-04-30'],
        ];
    }
}
