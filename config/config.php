<?php

use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRenderer;
use Framework\Renderer\TwigRendererFactory;
use Framework\Routing\Router;
use Framework\Routing\RouterTwigExtension;
use Framework\Twig\PagerFantaExtension;
use Framework\Twig\TextExtension;
use Framework\Twig\TimeExtension;
use Psr\Container\ContainerInterface;
use function DI\{factory, object, get};

return [
    'database.host' => 'localhost',
    'database.username' => 'root',
    'database.password' => 'root',
    'database.name' => 'blog',
    'views.path' => dirname(__DIR__).DIRECTORY_SEPARATOR.'views',
    'twig.extensions' => [
        get(RouterTwigExtension::class),
        get(PagerFantaExtension::class),
        get(TextExtension::class),
        get(TimeExtension::class)
    ],
    RendererInterface::class => factory(TwigRendererFactory::class),
    Router::class => object(),
    PDO::class => function (ContainerInterface $c) {
        $pdo = new PDO(
            'mysql:host='.$c->get('database.host').';dbname='.$c->get('database.name'),
            $c->get('database.username'),
            $c->get('database.password'),
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
        return $pdo;
    }
];