<?php

namespace Tests\Framework;

use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Tests\Framework\Modules\ErrorModule;
use Tests\Framework\Modules\StringModule;

/**
 * Class AppTest
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Tests
 */
class AppTest extends TestCase
{
    public function testRedirectTrailingSlash()
    {
        $app = new App();
        $response = $app->run(new ServerRequest('GET', '/demo/'));
        $this->assertContains('/demo', $response->getHeader('Location'));
        $this->assertEquals(301, $response->getStatusCode());
    }

    public function testError404()
    {
        $app = new App();
        $request = new ServerRequest('GET', '/azeaze');
        $response = $app->run($request);
        $this->assertEquals('<h1>Erreur 404</h1>', (string)$response->getBody());
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testConvertStringToResponse()
    {
        $app = new App([StringModule::class]);
        $request = new ServerRequest('GET', '/demo');
        $response = $app->run($request);
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testThrowExceptionIfNoResponseSend()
    {
        $app = new App([ErrorModule::class]);
        $request = new ServerRequest('GET', '/demo');
        $this->expectException(\Exception::class);
        $app->run($request);
    }
}
