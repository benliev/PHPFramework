<?php

require '../vendor/autoload.php';

use \Framework\App;
use \GuzzleHttp\Psr7\ServerRequest;
use function \Http\Response\send as send_response;
use \Framework\Renderer;

$renderer = new Renderer();
$renderer->addPath(dirname(__DIR__).DIRECTORY_SEPARATOR.'views');

$app = new App([
    \App\Blog\BlogModule::class
], compact('renderer'));

$response = $app->run(ServerRequest::fromGlobals());

send_response($response);
