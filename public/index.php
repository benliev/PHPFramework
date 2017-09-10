<?php

require dirname(__DIR__).'/vendor/autoload.php';

use App\Admin\AdminModule;
use App\Blog\BlogModule;
use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;
use function Http\Response\send;
use Framework\Middleware\{
    TrailingSlashMiddleware,
    MethodMiddleware,
    NotFoundMiddleware,
    RouterMiddleware,
    RouteDispatcherMiddleware
};
use Middlewares\Whoops;

$app = (new App(dirname(__DIR__).'/config/config.php'))
    ->addModule(AdminModule::class)
    ->addModule(BlogModule::class)
    ->pipe(TrailingSlashMiddleware::class)
    ->pipe(MethodMiddleware::class)
    ->pipe(RouterMiddleware::class)
    ->pipe(RouteDispatcherMiddleware::class)
    ->pipe(Whoops::class)
    ->pipe(NotFoundMiddleware::class)
;

if (php_sapi_name() != 'cli') {
    $response = $app->run(ServerRequest::fromGlobals());
    send($response);
}
