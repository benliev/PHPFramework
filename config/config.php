<?php

use function DI\factory;
use function DI\get;
use function DI\object;
use Framework\Database\PDOFactory;
use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRendererFactory;
use Framework\Routing\Router;
use Framework\Routing\RouterTwigExtension;
use Framework\Session\PhpSession;
use Framework\Session\SessionInterface;
use Framework\Twig\FlashExtension;
use Framework\Twig\BootstrapFormExtension;
use Framework\Twig\PagerFantaExtension;
use Framework\Twig\TextExtension;
use Framework\Twig\TimeExtension;

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
        get(FlashExtension::class),
        get(BootstrapFormExtension::class),
    ],
    RendererInterface::class => factory(TwigRendererFactory::class),
    Router::class => object(),
    PDO::class => factory(PDOFactory::class),
    SessionInterface::class => object(PhpSession::class),
];