<?php

namespace App\Blog;

use Framework\Renderer;
use Framework\Routing\RouterInterface;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogModule
{

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var Renderer
     */
    private $renderer;

    public function __construct(RouterInterface $router, Renderer $renderer)
    {
        $this->renderer = $renderer;
        $this->renderer->addPath('blog', __DIR__.'/views');

        $this->router = $router;
        $this->router->get('/blog', [$this, 'index'], 'blog.index');
        $this->router->get('/blog/{slug:[a-z\-]+}', [$this, 'show'], 'blog.show');
    }

    public function index(ServerRequestInterface $request): string
    {
        return $this->renderer->render('@blog/index');
    }

    public function show(ServerRequestInterface $request): string
    {
        $slug = $request->getAttribute('slug');
        return $this->renderer->render('@blog/show', compact('slug'));
    }
}
