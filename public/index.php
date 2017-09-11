<?php

// load composer autoloader
require dirname(__DIR__).'/vendor/autoload.php';

$modules = require(dirname(__DIR__).'/config/modules.php');
$middlewares = require(dirname(__DIR__).'/config/middlewares.php');

$app = new \Framework\App(dirname(__DIR__).'/config/config.php', $modules, $middlewares);

if (php_sapi_name() != 'cli') {
    $response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());
    \Http\Response\send($response);
}
