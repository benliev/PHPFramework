<?php


namespace Framework\Renderer;

/**
 * Class TwigRenderer
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework\Renderer
 */
class TwigRenderer implements RendererInterface
{

    /**
     * @var \Twig_Environment
     */
    private $twig;
    /**
     * @var \Twig_Loader_Filesystem
     */
    private $loader;

    /**
     * TwigRenderer constructor.
     * @param \Twig_Loader_Filesystem $loader
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Loader_Filesystem $loader, \Twig_Environment $twig)
    {
        $this->loader = $loader;
        $this->twig = $twig;
    }

    /**
     * Add path for load views
     * @param string $path
     * @param null|string|null $namespace
     */
    public function addPath(string $path, ?string $namespace = null) : void
    {
        $this->loader->addPath($path, $namespace);
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
    public function render(string $view, array $params = []) : string
    {
        return $this->twig->render($view.'.html.twig', $params);
    }

    /**
     * Add global variables for all views
     * @param string $name
     * @param $value
     */
    public function addGlobal(string $name, $value) : void
    {
        $this->twig->addGlobal($name, $value);
    }
}
