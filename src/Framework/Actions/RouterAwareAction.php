<?php

namespace Framework\Actions;

use Framework\Routing\Router;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * Class RouterAwareAction
 * Add methods to use router
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework\Actions
 */
trait RouterAwareAction
{
    /**
     * @var Router
     */
    private $router;

    /**
     * Return redirect response
     * @param string $path
     * @param array $params
     * @return ResponseInterface
     */
    private function redirect(string $path, array $params = []) : ResponseInterface
    {
        $redirectUri = $this->router->generateUri($path, $params);
        return new Response(301, ['Location' => $redirectUri]);
    }
}
