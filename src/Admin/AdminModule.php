<?php

namespace App\Admin;

use Framework\Module;
use Framework\Renderer\RendererInterface;

/**
 * Class AdminModule
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 */
class AdminModule extends Module
{
    /**
     * AdminModule constructor.
     * @param RendererInterface $renderer
     */
    public function __construct(RendererInterface $renderer)
    {
        $renderer->addPath(__DIR__ . '/views', 'admin');
    }

    /**
     * Path to definitions file
     * @return string|null
     */
    public static function getDefinitions(): ?string
    {
        return __DIR__ . '/config.php';
    }

    /**
     * Path to seeds directory
     * @return null|string
     */
    public static function getSeeds(): ?string
    {
        return null;
    }

    /**
     * Path to migrations directory
     * @return null|string
     */
    public static function getMigrations(): ?string
    {
        return null;
    }
}
