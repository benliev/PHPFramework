<?php

namespace App\Blog;

use App\Blog\Actions\BlogAction;
use Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Routing\Router;

class BlogModule extends Module
{

    const DEFINITIONS = __DIR__.'/config.php';
    const MIGRATIONS = __DIR__.DIRECTORY_SEPARATOR.'database/migrations';
    const SEEDS = __DIR__.'/database/seeds';

    public function __construct(string $prefix, Router $router, RendererInterface $renderer)
    {
        $renderer->addPath(__DIR__.'/views', 'blog');
        $router->get($prefix, BlogAction::class, 'blog.index');
        $router->get($prefix.'/{slug:[a-z\-]+}-{id:\d+}', BlogAction::class, 'blog.show');
    }
}
