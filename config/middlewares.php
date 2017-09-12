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
    TrailingSlashMiddleware::class,
    MethodMiddleware::class,
    TrailingSlashMiddleware::class,
    RouterMiddleware::class,
    RouteDispatcherMiddleware::class,
    Whoops::class,
    NotFoundMiddleware::class,
];
