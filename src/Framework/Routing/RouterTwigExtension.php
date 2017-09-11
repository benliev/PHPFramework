<?php


namespace Framework\Routing;

/**
 * Class RouterTwigExtension
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework\Routing
 */
class RouterTwigExtension extends \Twig_Extension
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
     * @return \Twig_SimpleFunction[]
     */
    public function getFunctions() : array
    {
        return [
          new \Twig_SimpleFunction('path', [$this, 'pathFor'])
        ];
    }

    /**
     * @param string $path
     * @param array $params
     * @return string
     */
    public function pathFor(string $path, array $params = []) : string
    {
        return $this->router->generateUri($path, $params);
    }
}
