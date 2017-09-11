<?php


namespace Framework\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Dispatcher Dispatch list of middleware.
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
        if (array_key_exists($this->index, $this->middlewares)) {
            $middleware = $this->middlewares[$this->index];
            $this->index++;
        } else {
            throw new \Exception("No middleware intercepted the request");
        }
        return $middleware->process($request, $this);
    }
}
