<?php

namespace App\Blog\Actions;

use App\Blog\Table\PostTable;
use Framework\Actions\RouterAwareAction;
use Framework\Renderer\RendererInterface;
use Framework\Routing\Router;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class BlogAction
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 */
class BlogAction
{

    use RouterAwareAction;

    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var PostTable
     */
    private $postTable;

    /**
     * BlogAction constructor.
     * @param RendererInterface $renderer
     * @param PostTable $postTable
     * @param Router $router
     * @internal param \PDO $pdo
     */
    public function __construct(RendererInterface $renderer, PostTable $postTable, Router $router)
    {
        $this->renderer = $renderer;
        $this->router = $router;
        $this->postTable = $postTable;
    }

    /**
     * @param Request $request
     * @return string
     */
    public function __invoke(Request $request) : string
    {
        $id = $request->getAttribute('id');
        if ($id) {
            return $this->show($request);
        }
        return $this->index();
    }

    /**
     * @return string
     */
    public function index() : string
    {
        $posts = $this->postTable->findPaginated();
        return $this->renderer->render('@blog/index', compact('posts'));
    }

    /**
     * Display one post
     * @param Request $request
     * @return ResponseInterface|string
     */
    public function show(Request $request)
    {
        $id = $request->getAttribute('id');
        $slug = $request->getAttribute('slug');
        $post = $this->postTable->find($id);

        if ($post->slug !== $slug) {
            return $this->redirect('blog.show', compact('slug', 'id'));
        }

        return $this->renderer->render('@blog/show', compact('post'));
    }
}
