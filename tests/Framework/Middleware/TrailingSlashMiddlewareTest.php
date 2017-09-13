<?php

namespace Tests\Framework\Middleware;

use Framework\Middleware\TrailingSlashMiddleware;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use Interop\Http\ServerMiddleware\DelegateInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class TrailingSlashMiddlewareTest
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Tests\Framework\Middleware
 */
class TrailingSlashMiddlewareTest extends TestCase
{

    public function testRedirect()
    {
        $delegate = $this->getMockBuilder(DelegateInterface::class)->getMock();
        $request = new ServerRequest('GET', '/demo/');
        $response = (new TrailingSlashMiddleware())->process($request, $delegate);
        $this->assertEquals(301, $response->getStatusCode());
        $this->assertContains('/demo', $response->getHeader('Location'));
    }

    public function testNotRedirect()
    {
        $delegate = $this->getMockBuilder(DelegateInterface::class)
            ->setMethods(['process'])
            ->getMock();

        $delegate->expects($this->once())
            ->method('process')
            ->willReturn(new Response());

        $request = new ServerRequest('GET', '/demo');
        (new TrailingSlashMiddleware())->process($request, $delegate);
    }
}
