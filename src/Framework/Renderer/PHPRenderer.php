<?php


namespace Framework\Renderer;

/**
 * Class Renderer
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework
 */
class PHPRenderer implements RendererInterface
{
    /**
     * @var string
     */
    const DEFAULT_NAMESPACE = '__MAIN__';

    /**
     * @var array
     */
    private $paths = [];

    /**
     * @var array $globals variables injected for all views
     */
    private $globals = [];

    public function __construct(?string $defaultPath = null)
    {
        if (!is_null($defaultPath)) {
            $this->addPath($defaultPath);
        }
    }

    /**
     * Add path for load views
     * @param string $path
     * @param null|string|null $namespace
     */
    public function addPath(string $path, ?string $namespace = null): void
    {
        $namespace = is_null($namespace) ? self::DEFAULT_NAMESPACE : $namespace;
        $this->paths[$namespace] = $path;
    }

    /**
     * Render a view
     * The path can be precised with namespace via addPath()
     * $this->render('@blog/view')
     * $this->render('view');
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render(string $view, array $params = []): string
    {
        $extension = '.php';
        $path = $this->hasNamespace($view) ?
            $this->replaceNamespace($view).$extension :
            $this->paths[self::DEFAULT_NAMESPACE].DIRECTORY_SEPARATOR.$view.$extension;
        ob_start();
        $renderer = $this;
        extract($this->globals);
        extract($params);
        require($path);
        return ob_get_clean();
    }

    private function hasNamespace(string $view): bool
    {
        return $view[0] === '@';
    }

    private function getNamespace(string $view): string
    {
        return substr($view, 1, strpos($view, '/') - 1);
    }

    private function replaceNamespace(string $view): string
    {
        $namespace = $this->getNamespace($view);
        return str_replace('@'.$namespace, $this->paths[$namespace], $view);
    }

    /**
     * Add global variables for all views
     * @param string $name
     * @param $value
     */
    public function addGlobal(string $name, $value): void
    {
        $this->globals[$name] = $value;
    }
}
