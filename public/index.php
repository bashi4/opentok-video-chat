<?php

require __DIR__ . '/../vendor/autoload.php';

$dot_env = __DIR__. '/../.env';
if (is_readable($dot_env)) {
    $dotenv = Dotenv\Dotenv::create(__DIR__. '/../');
    $dotenv->load();
}

$app = new \Slim\App(new \Slim\Container(
    require __DIR__ . '/../config/core.php'
));

$container = $app->getContainer();

$container->register(new App\ServiceProvider());

require __DIR__ . '/../config/routes.php';

$app->run();


