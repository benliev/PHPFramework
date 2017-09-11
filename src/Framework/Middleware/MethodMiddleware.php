<?php


namespace Framework\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class MethodMiddleware
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework\Middleware
 */
class MethodMiddleware implements MiddlewareInterface
{

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
        $parsedBody = $request->getParsedBody();
        if (isset($parsedBody['_method']) && in_array($parsedBody['_method'], ['DELETE', 'PUT'])) {
            $request = $request->withMethod($parsedBody['_method']);
        }
        return $delegate->process($request);
    }
}
