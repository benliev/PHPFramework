<?php

namespace App\Admin;

use Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Routing\Router;
use Interop\Container\ContainerInterface;

/**
 * Class AdminModule
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 */
class AdminModule extends Module
{
    const DEFINITIONS = __DIR__ . '/config.php';

    public function __construct(RendererInterface $renderer)
    {
        $renderer->addPath(__DIR__ . '/views', 'admin');
    }
}
