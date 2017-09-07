<?php

use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRenderer;
use Framework\Renderer\TwigRendererFactory;
use Framework\Routing\Router;
use Framework\Routing\RouterTwigExtension;
use Psr\Container\ContainerInterface;
use function DI\{factory, object, get};

return [
    'views.path' => dirname(__DIR__).DIRECTORY_SEPARATOR.'views',
    'twig.extensions' => [
        get(RouterTwigExtension::class)
    ],
    RendererInterface::class => factory(TwigRendererFactory::class),
    Router::class => object(),
];