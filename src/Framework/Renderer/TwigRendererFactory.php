<?php

namespace Framework\Renderer;

use Framework\Routing\RouterTwigExtension;
use Psr\Container\ContainerInterface;

/**
 * Class TwigRendererFactory
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework\Renderer
 */
class TwigRendererFactory
{
    /**
     * @param ContainerInterface $container
     * @return TwigRenderer
     */
    public function __invoke(ContainerInterface $container)
    {
        $viewPath = $container->get('views.path');
        $loader = new \Twig_Loader_Filesystem($viewPath);
        $twig = new \Twig_Environment($loader);

        if ($container->has('twig.extensions')) {
            foreach ($container->get('twig.extensions') as $extension) {
                $twig->addExtension($extension);
            }
        }

        return new TwigRenderer($loader, $twig);
    }
}
