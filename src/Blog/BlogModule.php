<?php

namespace App\Blog;

use App\Blog\Actions\AdminBlogAction;
use App\Blog\Actions\BlogAction;
use Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Routing\Router;
use Psr\Container\ContainerInterface;

class BlogModule extends Module
{

    const DEFINITIONS = __DIR__.'/config.php';
    const MIGRATIONS = __DIR__.DIRECTORY_SEPARATOR.'database/migrations';
    const SEEDS = __DIR__.'/database/seeds';

    public function __construct(ContainerInterface $container)
    {
        $renderer = $container->get(RendererInterface::class);
        $router = $container->get(Router::class);
        $blogPrefix = $container->get('blog.prefix');

        $renderer->addPath(__DIR__.'/views', 'blog');

        $router->get($blogPrefix, BlogAction::class, 'blog.index');
        $router->get($blogPrefix.'/{slug:[a-z\-]+}-{id:\d+}', BlogAction::class, 'blog.show');

        if ($container->has('admin.prefix')) {
            $adminPrefix = $container->get('admin.prefix');
            $router->crud("$adminPrefix/posts", AdminBlogAction::class, 'blog.admin');
        }
    }
}
