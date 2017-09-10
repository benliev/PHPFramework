<?php

namespace Framework\Actions;

use Framework\Renderer\RendererInterface;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * Class RendererAwareAction
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework\Actions
 */
trait RendererAwareAction
{
    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * Render a view
     * @param string $view
     * @param array $params
     * @return ResponseInterface
     */
    private function render(string $view, array $params = []) : ResponseInterface
    {
        $content = $this->renderer->render($view, $params);
        return new Response(200, [], $content);
    }
}
