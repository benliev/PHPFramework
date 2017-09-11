<?php

use Framework\Database\PDOFactory;
use Framework\Renderer\{
    RendererInterface,
    TwigRenderer,
    TwigRendererFactory
};
use Framework\Routing\{
    Router,
    RouterTwigExtension
};
use Framework\Twig\{
    PagerFantaExtension,
    TextExtension,
    TimeExtension
};
use Psr\Container\ContainerInterface;
use function DI\{factory, object, get};

return [
    'database.host' => 'localhost',
    'database.username' => 'root',
    'database.password' => 'root',
    'database.name' => 'blog',
    'views.path' => dirname(__DIR__).'/views',
    'twig.extensions' => [
        get(RouterTwigExtension::class),
        get(PagerFantaExtension::class),
        get(TextExtension::class),
        get(TimeExtension::class),
    ],
    RendererInterface::class => factory(TwigRendererFactory::class),
    Router::class => object(),
    PDO::class => factory(PDOFactory::class),
];