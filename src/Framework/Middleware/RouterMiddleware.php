<?php

namespace Framework\Middleware;

use Framework\Routing\Router;
use GuzzleHttp\Psr7\Response;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class RouterMiddleware
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework\Middleware
 */
class RouterMiddleware implements MiddlewareInterface
{

    /**
     * @var Router
     */
    private $router;

    /**
     * RouterMiddleware constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Process an incoming server request and return a response, optionally delegating
     * to the next middleware component to create the response.
     *
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $route = $this->router->match($request);
        if (is_null($route)) {
            return $delegate->process($request);
        }
        foreach ($route->getParams() as $key => $value) {
            $request = $request->withAttribute($key, $value);
        }
        $request = $request->withAttribute(get_class($route), $route);
        return $delegate->process($request);
    }
}
