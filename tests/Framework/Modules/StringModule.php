<?php

namespace Tests\Framework\Modules;

use Framework\Renderer;
use Framework\Routing\Router;

/**
 * Class StringModule
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Tests\Framework\Modules
 */
class StringModule
{
    public function __construct(Router $router)
    {
        $router->get('/demo', function () {
            return 'DEMO';
        }, 'demo');
    }
}
