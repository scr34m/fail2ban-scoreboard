<?php
$app->get(
    '/',
    function () use ($app) {
        $events = $app->redis->lRange('events', 0, -1);
        foreach ($events as $k => $event) {
            list($host, $service, $ip, $time) = explode('#', $event);
            $events[$k] = array ('host' => $host, 'service' => $service, 'ip' => $ip, 'time' => $time);
        }
        $ips = $app->redis->zRevRange('ips', 0, -1, true);
        $app->render('index.php', array('events' => $events, 'ips' => $ips));
    }
);

$app->get(
    '/info/:ip',
    function ($ip) use ($app) {
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new Exception('Not a valid IP address', 400);
        }

        $hash = $app->redis->hGetAll('ip' . $ip);
        if (sizeof($hash) == 0) {
            throw new Exception('Unknown IP address', 400);
        }

        $events = $app->redis->lRange('ip:' . $ip . ':events', 0, -1);
        foreach ($events as $k => $event) {
            list($host, $service, $time) = explode('#', $event);
            $events[$k] = array ('host' => $host, 'service' => $service, 'time' => $time);
        }

        $app->render('info.php', array('events' => $events, 'ip' => $ip, 'hash' => $hash));
    }
);

// register ban event
$app->get(
    '/hit/:server/:service/:ip',
    function ($server, $service, $ip) use ($app) {
        if ($server == '') {
            throw new Exception('Server is empty', 400);
        }
        if ($service == '') {
            throw new Exception('Service is empty', 400);
        }
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new Exception('Not a valid IP address', 400);
        }

        $app->redis->zIncrBy('ips', 1, $ip);

        $app->redis->hIncrBy('ip' . $ip, 'hits', 1);
        $app->redis->hSet('ip' . $ip, 'latest', time());

        $app->redis->cappedPush('ip:' . $ip . ':events', $server . '#' . $service . '#' . time(), 50);

        $app->redis->cappedPush('events', $server . '#' . $service . '#' . $ip . '#' . time(), 50);

        $app->log->info($ip . ' is banned on ' . $server . '\'s service: ' . $service);

        $app->response->status(200);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->body(json_encode(array ('message' => 'OK')));
        $app->stop();
    }
)->via('GET', 'POST');
