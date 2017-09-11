<?php

namespace Framework\Middleware;

use Framework\Routing\Route;
use GuzzleHttp\Psr7\Response;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class RouteDispatcherMiddleware
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework\Middleware
 */
class RouteDispatcherMiddleware implements MiddlewareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * RouteDispatcherMiddleware constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Process an incoming server request and return a response, optionally delegating
     * to the next middleware component to create the response.
     *
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     * @return ResponseInterface
     * @throws \Exception The response is not a string or an instance of ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate): ResponseInterface
    {
        /** @var Route $route */
        $route = $request->getAttribute(Route::class);
        if (is_null($route)) {
            return $delegate->process($request);
        }
        $callback = $route->getCallback();
        if (is_string($callback)) {
            $callback = $this->container->get($callback);
        }
        $response = call_user_func_array($callback, [$request]);

        if (is_string($response)) {
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new \Exception("The response is not a string or an instance of ResponseInterface");
        }
    }
}
