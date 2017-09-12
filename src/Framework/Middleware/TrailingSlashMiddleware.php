<?php

namespace Framework\Middleware;

use GuzzleHttp\Psr7\Response;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class TrailingSlashMiddleware
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 */
class TrailingSlashMiddleware implements MiddlewareInterface
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
    public function process(ServerRequestInterface $request, DelegateInterface $delegate) : ResponseInterface
    {
        $uri = (string)$request->getUri();

        if (!empty($uri) && $uri[-1] == '/') {
            return new Response(301, ['Location' => substr($uri, 0, -1)]);
        }
        return $delegate->process($request);
    }
}
