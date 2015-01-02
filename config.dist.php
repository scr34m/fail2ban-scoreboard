<?php
return array(
    'slim' => array(
        'view' => '\Slim\LayoutView',
        'templates.path' => __DIR__ . '/src/templates/',
        'layout' => 'layouts/default.php',
        'debug' => true,
        'mode' => 'development',
        'log.level' => \Slim\Log::DEBUG,
        'log.enabled' => true,
        'log.writer' => new \Scoreboard\Logger(
            array(
                'path' => __DIR__ . '/logs',
                'format' => 'y-m-d',
                'mode' => 0666
            )
        ),
    ),
    'redis' => array(
        'host' => ''
    )
);