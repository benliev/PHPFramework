<?php

namespace App\Blog;

use App\Blog\Actions\AdminBlogAction;
use App\Blog\Actions\BlogAction;
use App\Blog\Actions\CategoryCrudAction;
use App\Blog\Actions\PostCrudAction;
use Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Routing\Router;
use Psr\Container\ContainerInterface;

class BlogModule extends Module
{
    /**
     * BlogModule constructor.
     * @param ContainerInterface $container
     */
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
            $router->crud("$adminPrefix/posts", PostCrudAction::class, 'blog.admin.posts');
            $router->crud("$adminPrefix/categories", CategoryCrudAction::class, 'blog.admin.categories');
        }
    }

    /**
     * Path to definitions file
     * @return string|null
     */
    public static function getDefinitions(): ?string
    {
        return __DIR__.'/config.php';
    }

    /**
     * Path to seeds directory
     * @return null|string
     */
    public static function getSeeds(): ?string
    {
        return __DIR__.'/database/seeds';
    }

    /**
     * Path to migrations directory
     * @return null|string
     */
    public static function getMigrations(): ?string
    {
        return __DIR__.DIRECTORY_SEPARATOR.'database/migrations';
    }
}
