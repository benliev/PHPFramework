<?php

require '../vendor/autoload.php';

use \Framework\App;
use \Framework\Renderer\TwigRenderer;
use \GuzzleHttp\Psr7\ServerRequest;
use function \Http\Response\send as send_response;
use \DI\ContainerBuilder;

$modules = [
    \App\Blog\BlogModule::class
];

$builder = new ContainerBuilder();
$builder->addDefinitions(dirname(__DIR__).'/config/config.php');
$builder->addDefinitions(dirname(__DIR__).'/config.php');

foreach ($modules as $module) {
    if ($modules::DEFINITIONS) {
        $builder->addDefinitions($modules::DEFINITIONS);
    }
}

$container = $builder->build();

$app = new App($container, $modules);

$response = $app->run(ServerRequest::fromGlobals());

send_response($response);
