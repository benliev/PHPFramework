<?php

namespace Framework\Routing;

use Psr\Http\Message\ServerRequestInterface;

interface RouterInterface
{
    /**
     * Register a route
     * @param string $path
     * @param callable $callable
     * @param string $name
     */
    public function any(string $path, callable $callable, string $name);
    
    /**
     * Register a route with get method
     * @param string $path
     * @param callable $callable
     * @param string $name
     */
    public function get(string $path, callable $callable, string $name);

    /**
     * Register a route with post method
     * @param string $path
     * @param callable $callable
     * @param string $name
     */
    public function post(string $path, callable $callable, string $name);

    /**
     * Register a route with put method
     * @param string $path
     * @param callable $callable
     * @param string $name
     */
    public function put(string $path, callable $callable, string $name);

    /**
     * Register a route with delete method
     * @param string $path
     * @param callable $callable
     * @param string $name
     */
    public function delete(string $path, callable $callable, string $name);

    /**
     * Match the uri in request with a route defined or null if not found the match
     * @param ServerRequestInterface $request
     * @return RouteInterface the route or null if no match
     */
    public function match(ServerRequestInterface $request): ?RouteInterface;

    /**
     * Generate URI with the route name and params
     * @param string $name the route name
     * @param array $params params in the route path
     * @return string
     */
    public function generateUri(string $name, array $params): ?string;
}
