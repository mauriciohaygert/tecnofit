<?php

global $diContainer, $psr17Factory;

$router = new League\Route\Router;
$strategy = new League\Route\Strategy\JsonStrategy($psr17Factory);
$strategy->setContainer($diContainer);
$router->setStrategy($strategy);

$router->map('GET', '/', 'App\Controller\IndexController::indexAction');
$router->map('GET', 'movement/{movementId:number}/ranking', 'App\Controller\MovementController::rankingMovementAction');
$router->map('GET', 'movement/{movementName:word}/ranking', 'App\Controller\MovementController::rankingMovementAction');
$router->map('GET', 'ranking/movement/{movementId:number}', 'App\Controller\MovementController::rankingMovementAction');
$router->map('GET', 'ranking/movement/{movementName:word}', 'App\Controller\MovementController::rankingMovementAction');

return $router;