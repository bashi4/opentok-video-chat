<?php

$app->map(['get', 'post'], '/', 'App\Controller\Controller:index');
$app->get('/rooms/{sessionId}', 'App\Controller\Controller:room');
