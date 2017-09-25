<?php

use Framework\Middleware\{
    MethodMiddleware,
    NotFoundMiddleware,
    RouteDispatcherMiddleware,
    RouterMiddleware,
    TrailingSlashMiddleware
};
use Middlewares\Whoops;

return [
    Whoops::class,
    TrailingSlashMiddleware::class,
    MethodMiddleware::class,
    TrailingSlashMiddleware::class,
    RouterMiddleware::class,
    RouteDispatcherMiddleware::class,
    NotFoundMiddleware::class,
];
