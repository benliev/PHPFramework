<?php

namespace Tests\Framework\Modules;

use \Framework\Routing\RouterInterface;

/**
 * Class ErrorModule
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 */
class ErrorModule
{
    public function __construct(RouterInterface $router)
    {
        $router->get('/demo', function () {
            return new \stdClass();
        }, 'demo');
    }
}
