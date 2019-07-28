<?php

require __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\App(new \Slim\Container(
    require __DIR__ . '/../config/core.php'
));

$container = $app->getContainer();

$container->register(new App\ServiceProvider());

require __DIR__ . '/../config/routes.php';

$app->run();


