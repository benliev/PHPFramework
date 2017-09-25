<?php

namespace Framework\Twig;

use Framework\Routing\Router;
use Pagerfanta\Pagerfanta;
use Pagerfanta\View\TwitterBootstrap3View;
use Twig_SimpleFunction;

/**
 * Class TwigPagerFantaExtension
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 */
class PagerFantaExtension extends \Twig_Extension
{
    /**
     * @var Router
     */
    private $router;

    /**
     * PagerFantaExtension constructor.
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
            new Twig_SimpleFunction(
                'paginate',
                [$this, 'paginate'],
                ['is_safe' => ['html']]
            )
        ];
    }

    /**
     * @param Pagerfanta $paginatedResult
     * @param string $route
     * @param array $queryArgs
     * @return string
     */
    public function paginate(Pagerfanta $paginatedResult, string $route, array $queryArgs = []): string
    {
        $view = new TwitterBootstrap3View();
        return $view->render($paginatedResult, function (int $page) use ($route, $queryArgs) {
            if ($page > 1) {
                $queryArgs['page'] = $page;
            }
            return $this->router->generateUri($route, [], $queryArgs);
        });
    }
}
