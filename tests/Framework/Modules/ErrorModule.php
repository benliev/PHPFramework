<?php

namespace Tests\Framework\Modules;

use \Framework\Routing\Router;

/**
 * Class ErrorModule
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 */
class ErrorModule
{
    public function __construct(Router $router)
    {
        $router->get('/demo', function () {
            return new \stdClass();
        }, 'demo');
    }
}
