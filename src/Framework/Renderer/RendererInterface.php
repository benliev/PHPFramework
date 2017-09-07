<?php

namespace Framework\Renderer;

/**
 * Class Renderer
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework
 */
interface RendererInterface
{
    /**
     * Add path for load views
     * @param string $path
     * @param null|string|null $namespace
     */
    public function addPath(string $path, ?string $namespace = null) : void;

    /**
     * Render a view
     * The path can be precised with namespace via addPath()
     * $this->render('@blog/view')
     * $this->render('view');
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render(string $view, array $params = []) : string;

    /**
     * Add global variables for all views
     * @param string $name
     * @param $value
     */
    public function addGlobal(string $name, $value) : void;
}
