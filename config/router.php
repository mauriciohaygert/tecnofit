<?php

global $diContainer, $psr17Factory;

$router = new League\Route\Router;
$strategy = new League\Route\Strategy\JsonStrategy($psr17Factory);
$strategy->setContainer($diContainer);
$router->setStrategy($strategy);

$router->map('GET', '/', 'App\Controller\IndexController::indexAction');
$router->map('GET', 'ranking/movement/{movementId:number}', 'App\Controller\RankingController::rankingMovementAction');
$router->map('GET', 'ranking/movement/{movementName:word}', 'App\Controller\RankingController::rankingMovementAction');

return $router;