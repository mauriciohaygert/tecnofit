<?php

use League\Route\Router;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

require __DIR__.'/../vendor/autoload.php';
require __DIR__ . '/../config/env.php';

$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

/** @var ContainerInterface $diContainer */
$diContainer = require_once __DIR__ . '/../config/di.php';

/** @var Router $router */
$router = require_once(__DIR__ . '/../config/router.php');

$creator = new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory,  // StreamFactory
);
$response = $router->dispatch($creator->fromGlobals());

http_response_code($response->getStatusCode());
foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

printf($response->getBody());
