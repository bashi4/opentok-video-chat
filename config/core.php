<?php

return [
    'settings' => [
        'displayErrorDetails' => true, 
        'renderer'            => [
            'blade_template_path' => __DIR__ . '/../views',
            'blade_cache_path'    => __DIR__ . '/../cache', 
        ],
    ],
    'view' => function ($c) {
        return new \Slim\Views\Blade(
            $c['settings']['renderer']['blade_template_path'],
            $c['settings']['renderer']['blade_cache_path'],
        );
    },
];
