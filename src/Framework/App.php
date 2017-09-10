<?php

namespace Framework;

use DI\ContainerBuilder;
use Framework\Middleware\Dispatcher;
use Framework\Routing\Router;
use GuzzleHttp\Psr7\Response;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
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
     * @var Module[]
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
     * @var string
     */
    private $definition;

    /**
     * @var string[]
     */
    private $middlewares;

    /**
     * App constructor.
     * @param string $definition
     */
    public function __construct(string $definition)
    {
        $this->definition = $definition;
    }

    /**
     * Add module to app
     * @param string $module
     * @return App
     */
    public function addModule(string $module) : self
    {
        $this->modules[] = $module;
        return $this;
    }

    /**
     * Add a middleware
     * @param string $middleware
     * @return App
     */
    public function pipe(string $middleware) : self
    {
        $this->middlewares [] = $middleware;
        return $this;
    }

    /**
     * Run the app with the request injected
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Exception
     */
    public function run(ServerRequestInterface $request) : ResponseInterface
    {
        // Build container
        $builder = new ContainerBuilder();
        $builder->addDefinitions($this->definition);
        foreach ($this->modules as $module) {
            if ($module::DEFINITIONS) {
                $builder->addDefinitions($module::DEFINITIONS);
            }
        }
        $container = $builder->build();

        // Create modules
        foreach ($this->modules as $module) {
            $container->get($module);
        }

        // Create a dispatcher and process middlewares recorded
        $dispatcher = new Dispatcher();
        foreach ($this->middlewares as $middleware) {
            $dispatcher->pipe($container->get($middleware));
        }
        return $dispatcher->process($request);
    }
}
