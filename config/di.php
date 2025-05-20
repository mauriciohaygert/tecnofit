<?php

use Psr\Container\ContainerInterface;

$builder = new \DI\ContainerBuilder();

$builder->addDefinitions([
    PDO::class => function (): PDO {

        return new PDO(
            'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_DATABASE'),
            getenv('DB_USERNAME'),
            getenv('DB_PASSWORD')
        );
    }
]);
/** @var ContainerInterface $container */
$container = $builder->build();

return $container;
