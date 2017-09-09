<?php

namespace Tests\Framework;

use App\Blog\BlogModule;
use Framework\App;
use Framework\Routing\Router;
use Framework\Routing\RouterInterface;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class RouterTest
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Tests
 */
class RouterTest extends TestCase
{
    /**
     * @var Router
     */
    private $router;

    public function setUp()
    {
        $this->router = new Router();
    }

    public function testGetMethod()
    {
        $request = new ServerRequest('GET', '/blog');
        $this->router->get('/blog', function () {
            return 'hello';
        }, 'blog');
        $route = $this->router->match($request);
        $this->assertEquals('blog', $route->getName());
        $this->assertEquals('hello', call_user_func_array($route->getCallback(), [$request]));
    }

    public function testGetMethodIfURLDoesNotExists()
    {
        $request = new ServerRequest('GET', '/blog/mon-slug-8');
        $this->router->get('/blogaze', function () {
            return 'hello';
        }, 'blog');
        $route = $this->router->match($request);
        $this->assertNull($route);
    }

    public function testGetMethodWithParameters()
    {
        $request = new ServerRequest('GET', '/blog/mon-slug-8');
        $this->router->get('/blog', function () {
            return 'azeaze';
        }, 'posts');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function () {
            return 'hello';
        }, 'post.show');
        $route = $this->router->match($request);
        $this->assertEquals('post.show', $route->getName());
        $this->assertEquals('hello', call_user_func_array($route->getCallback(), [$request]));
        $this->assertEquals(['slug' => 'mon-slug', 'id' => '8'], $route->getParams());

        //test invalid url
        $route = $this->router->match(new ServerRequest('GET', '/blog/mon_slug-8'));
        $this->assertNull($route);
    }

    public function testGenerateUri()
    {
        $this->router->get('/blog', function () {
            return 'azeaze';
        }, 'posts');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function () {
            return 'hello';
        }, 'post.show');
        $uri = $this->router->generateUri('post.show', ['slug' => 'mon-article', 'id' => 18]);
        $this->assertEquals('/blog/mon-article-18', $uri);
    }

    public function testGenerateUriWithQueryParams()
    {
        $this->router->get('/blog', function () {
            return '';
        }, 'posts.index');
        $uri = $this->router->generateUri('posts.index', [], ['page' => 2]);
        $this->assertEquals('/blog?page=2', $uri);
    }
}
