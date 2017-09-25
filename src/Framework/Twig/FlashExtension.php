<?php

namespace Framework\Twig;

use Framework\Session\FlashService;
use Twig_SimpleFunction;

/**
 * Class FlashExtension
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework\Twig
 */
class FlashExtension extends \Twig_Extension
{

    /**
     * @var FlashService
     */
    private $flash;

    /**
     * FlashExtension constructor.
     * @param FlashService $flash
     */
    public function __construct(FlashService $flash)
    {
        $this->flash = $flash;
    }

    /**
     * @return Twig_SimpleFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new Twig_SimpleFunction('flash', [$this, 'getFlash'])
        ];
    }

    /**
     * @param $type
     * @return null|string
     */
    public function getFlash($type): ?string
    {
        return $this->flash->get($type);
    }
}
