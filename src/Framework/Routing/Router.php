<?php

namespace Framework\Routing;

use Framework\Routing\Route;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Router\FastRouteRouter;
use \Zend\Expressive\Router\Route as ZendRoute;

/**
 * Register and match routes
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework
 */
class Router
{
    /**
     * @var FastRouteRouter
     */
    private $router;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->router = new FastRouteRouter();
    }

    /**
     * Register a route with method precised
     * @param string $path
     * @param callable|string $callable
     * @param string $name
     */
    public function any(string $path, $callable, string $name)
    {
        $this->router->addRoute(new ZendRoute($path, $callable, ZendRoute::HTTP_METHOD_ANY, $name));
    }

    /**
     * Register a route with get method
     * @param string $path
     * @param callable|string $callable
     * @param string $name
     */
    public function get(string $path, $callable, ?string $name = null)
    {
        $this->router->addRoute(new ZendRoute($path, $callable, ['GET'], $name));
    }

    /**
     * Register a route with post method
     * @param string $path
     * @param callable|string $callable
     * @param string $name
     */
    public function post(string $path, $callable, ?string $name = null)
    {
        $this->router->addRoute(new ZendRoute($path, $callable, ['POST'], $name));
    }

    /**
     * Register a route with post method
     * @param string $path
     * @param callable|string $callable
     * @param string $name
     */
    public function put(string $path, $callable, ?string $name = null)
    {
        $this->router->addRoute(new ZendRoute($path, $callable, ['PUT'], $name));
    }

    /**
     * Register a route with post method
     * @param string $path
     * @param callable|string $callable
     * @param string $name
     */
    public function delete(string $path, $callable, ?string $name = null)
    {
        $this->router->addRoute(new ZendRoute($path, $callable, ['DELETE'], $name));
    }

    /**
     * Generate CRUD routes
     * @param string $prefixPath
     * @param $callable
     * @param string $prefixName
     */
    public function crud(string $prefixPath, $callable, string $prefixName)
    {
        $this->get($prefixPath, $callable, "$prefixName.index");
        $this->get("$prefixPath/new", $callable, "$prefixName.create");
        $this->post("$prefixPath/new", $callable);
        $this->get("$prefixPath/{id:\d+}", $callable, "$prefixName.edit");
        $this->put("$prefixPath/{id:\d+}", $callable);
        $this->delete($prefixPath, $callable, "$prefixName.delete");
    }

    /**
     * Match the uri in request with a route defined or null if not found the match
     * @param ServerRequestInterface $request
     * @return Route the route or null if not match
     */
    public function match(ServerRequestInterface $request): ?Route
    {
        $result = $this->router->match($request);
        if ($result->isSuccess()) {
            return new Route(
                $result->getMatchedRouteName(),
                $result->getMatchedMiddleware(),
                $result->getMatchedParams()
            );
        }
        return null;
    }

    /**
     * Generate URI with the route name and params
     * @param string $name the route name
     * @param array $params params in the route path
     * @param array $queryParams
     * @return null|string
     */
    public function generateUri(string $name, array $params = [], array $queryParams = []): ?string
    {
        $uri = $this->router->generateUri($name, $params);
        if (!empty($queryParams)) {
            $uri .= '?' . http_build_query($queryParams);
        }
        return $uri;
    }
}
