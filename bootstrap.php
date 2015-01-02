<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/functions.php';

$config = require_once 'config.php';

$app = new \Scoreboard\Slim($config['slim']);
$app->hook(
    'slim.before',
    function () use ($app) {
        $app->view()->appendData(array('baseUrl' => '/'));
    }
);

$app->config('redis', $config['redis']);
$app->container->singleton(
    'redis',
    function () use ($app) {
        $config = array_merge(array('host' => '127.0.0.1', 'port' => 6379, 'password' => false), $app->config('redis'));
        return new \Scoreboard\Redis($config['host'], $config['port'], $config['password']);
    }
);

// used only when not in debug mode
$app->error(
    function (Exception $e) use ($app) {
        if ($e->getCode() !== 0) {
            $app->response->status($e->getCode());
        }
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->body(json_encode(array ('error' => $e->getMessage())));
        $app->stop();
    }
);

require __DIR__ . '/src/routes.php';

$app->run();