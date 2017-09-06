<?php

namespace App\Blog;

use Framework\Routing\RouterInterface;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogModule
{

    public function __construct(RouterInterface $router)
    {
        $router->get('/blog', [$this, 'index'], 'blog.index');
        $router->get('/blog/{slug:[a-z\-]+}', [$this, 'show'], 'blog.show');
    }

    public function index(ServerRequestInterface $request): string
    {
        return '<h1>Bienvenue sur le blog</h1>';
    }

    public function show(ServerRequestInterface $request): string
    {
        $slug = $request->getAttribute('slug');
        return "<h1>Bienvenue sur l'article $slug</h1>";
    }
}
