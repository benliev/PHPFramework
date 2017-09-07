<?php

namespace Framework;

use Framework\Routing\Router;
use GuzzleHttp\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class App
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework
 */
class App
{
    /**
     * @var array
     */
    private $modules = [];

    /**
     * @var Router
     */
    private $router;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * App constructor.
     * @param ContainerInterface $container
     * @param string[] $modules List of modules to load
     */
    public function __construct(ContainerInterface $container, array $modules = [])
    {
        foreach ($modules as $module) {
            $this->modules[] = $container->get($module);
        }
        $this->container = $container;
        $this->router = $container->get(Router::class);
    }

    /**
     * Run the app with the request injected
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Exception
     */
    public function run(ServerRequestInterface $request) : ResponseInterface
    {
        $uri = $request->getUri()->getPath();

        if (!empty($uri) && $uri[-1] == '/') {
            return new Response(301, ['Location' => substr($uri, 0, -1)]);
        }

        $route = $this->router->match($request);

        if (is_null($route)) {
            return new Response(404, [], '<h1>Erreur 404</h1>');
        }

        foreach ($route->getParams() as $key => $value) {
            $request = $request->withAttribute($key, $value);
        }
        $callback = $route->getCallback();
        if (is_string($callback)) {
            $callback = $this->container->get($callback);
        }
        $response = call_user_func_array($route->getCallback(), [$request]);

        if (is_string($response)) {
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new \Exception("The response is not a string or an instance of ResponseInterface");
        }
    }
}
