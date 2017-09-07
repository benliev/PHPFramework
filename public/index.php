<?php

require dirname(__DIR__).'/vendor/autoload.php';

use \Framework\App;
use \Framework\Renderer\TwigRenderer;
use \GuzzleHttp\Psr7\ServerRequest;
use function \Http\Response\send;
use \DI\ContainerBuilder;

$modules = [
    \App\Blog\BlogModule::class
];

$builder = new ContainerBuilder();
$builder->addDefinitions(dirname(__DIR__).'/config/config.php');
$builder->addDefinitions(dirname(__DIR__).'/config.php');

foreach ($modules as $module) {
    if ($module::DEFINITIONS) {
        $builder->addDefinitions($module::DEFINITIONS);
    }
}

$container = $builder->build();

if (php_sapi_name() != 'cli') {
    $app = new App($container, $modules);
    $response = $app->run(ServerRequest::fromGlobals());
    send($response);
}
