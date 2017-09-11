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
     * App constructor.
     * @param string $definition
     * @param array $modules
     * @param array $middlewares
     */
    public function __construct(string $definition, array $modules, array $middlewares)
    {
        $this->definition = $definition;
        $this->modules = $modules;
        $this->middlewares = $middlewares;
    }

    /**
     * Run the app with the request injected
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Exception
     */
    public function run(ServerRequestInterface $request) : ResponseInterface
    {
        // Create modules
        foreach ($this->modules as $module) {
            $this->getContainer()->get($module);
        }

        // Create a dispatcher and process middlewares recorded
        $dispatcher = new Dispatcher();
        foreach ($this->middlewares as $middleware) {
            $dispatcher->pipe($this->getContainer()->get($middleware));
        }
        return $dispatcher->process($request);
    }

    /**
     * @return \DI\Container|ContainerInterface
     */
    public function getContainer()
    {
        if (is_null($this->container)) {
            // Build container
            $builder = new ContainerBuilder();
            $builder->addDefinitions($this->definition);
            foreach ($this->modules as $module) {
                if ($module::DEFINITIONS) {
                    $builder->addDefinitions($module::DEFINITIONS);
                }
            }
            $this->container = $builder->build();
        }
        return $this->container;
    }
}
