<?php


namespace Framework\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Dispatcher Dispatch middlewares.
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework\Middleware
 */
class Dispatcher implements DelegateInterface
{
    /**
     * @var MiddlewareInterface[]
     */
    private $middlewares;

    /**
     * @var int
     */
    private $index = 0;

    /**
     * Add middleware
     * @param MiddlewareInterface $middleware
     * @return Dispatcher
     */
    public function pipe(MiddlewareInterface $middleware) : self
    {
        $this->middlewares[] = $middleware;
        return $this;
    }

    /**
     * Dispatch the next available middleware and return the response.
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Exception
     */
    public function process(ServerRequestInterface $request) : ResponseInterface
    {
        $middleware = $this->getMiddleware();
        if (is_null($middleware)) {
            throw new \Exception("No middleware intercepted the request");
        }
        return $middleware->process($request, $this);
    }

    /**
     * Get the current middleware
     * @return MiddlewareInterface|null
     */
    private function getMiddleware() : ?MiddlewareInterface
    {
        if (array_key_exists($this->index, $this->middlewares)) {
            return $this->middlewares[$this->index++];
        }
        return null;
    }
}
