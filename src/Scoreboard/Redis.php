<?php
namespace Scoreboard;

class Redis extends \Redis
{
    public function __construct($host = '127.0.0.1', $port = 6379, $password = false)
    {
        if (!$this->connect($host, $port)) {
            throw new \Exception("Invalid connection on $host:$port");
        }
        if ($password && !$this->auth($password)) {
            throw new \Exception('Invalid password.');
        }
    }

    public function cappedPush($key, $value, $limit)
    {
        $this->lPush($key, $value);
        $this->lTrim($key, 0, $limit - 1);
    }
}