<?php

global $diContainer, $psr17Factory;
const RANKING_ACTION = 'App\Controller\MovementController::rankingMovementAction';

$router = new League\Route\Router;
$strategy = new League\Route\Strategy\JsonStrategy($psr17Factory);
$strategy->setContainer($diContainer);
$router->setStrategy($strategy);

$router->map('GET', '/', 'App\Controller\IndexController::indexAction');
$router->map('GET', 'movement/{movementId:number}/ranking', RANKING_ACTION);
$router->map('GET', 'movement/{movementName:word}/ranking', RANKING_ACTION);
$router->map('GET', 'ranking/movement/{movementId:number}', RANKING_ACTION);
$router->map('GET', 'ranking/movement/{movementName:word}', RANKING_ACTION);

return $router;