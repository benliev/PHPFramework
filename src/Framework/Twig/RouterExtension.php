<?php

namespace Framework\Twig;

use Framework\Routing\Router;
use Twig_SimpleFunction;

/**
 * Class RouterExtension
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework\Routing
 */
class RouterExtension extends \Twig_Extension
{

    /**
     * @var Router
     */
    private $router;

    /**
     * RouterTwigExtension constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @return Twig_SimpleFunction[]
     */
    public function getFunctions() : array
    {
        return [
          new Twig_SimpleFunction('path', [$this, 'pathFor'])
        ];
    }

    /**
     * @param string $name
     * @param array $params
     * @param array $queryParams
     * @return string
     */
    public function pathFor(string $name, array $params = [], array $queryParams = []) : string
    {
        return $this->router->generateUri($name, $params, $queryParams);
    }
}
