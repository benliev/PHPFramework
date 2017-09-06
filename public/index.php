<?php

require '../vendor/autoload.php';

use \Framework\App;
use \GuzzleHttp\Psr7\ServerRequest;
use function \Http\Response\send as send_response;

$app = new App([
    \App\Blog\BlogModule::class
]);

$response = $app->run(ServerRequest::fromGlobals());

send_response($response);
