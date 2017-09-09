<?php

namespace App\Blog\Actions;

use App\Blog\Table\PostTable;
use Framework\Actions\RendererAwareAction;
use Framework\Actions\RouterAwareAction;
use Framework\Renderer\RendererInterface;
use Framework\Routing\Router;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class BlogAction
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 */
class BlogAction
{
    /**
     * Add methods to use router
     */
    use RouterAwareAction;

    /**
     * Add methods to use renderer
     */
    use RendererAwareAction;

    /**
     * @var PostTable
     */
    private $postTable;

    /**
     * BlogAction constructor.
     * @param RendererInterface $renderer
     * @param PostTable $postTable
     * @param Router $router
     */
    public function __construct(
        RendererInterface $renderer,
        PostTable $postTable,
        Router $router
    ) {
    
        $this->renderer = $renderer;
        $this->router = $router;
        $this->postTable = $postTable;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request) : Response
    {
        $id = $request->getAttribute('id');
        if ($id) {
            return $this->show($request);
        }
        return $this->index($request);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) : Response
    {
        $params = $request->getQueryParams();
        $posts = $this->postTable->findPaginated(10, $params['page'] ?? 1);
        return $this->render('@blog/index', compact('posts'));
    }

    /**
     * Display one post
     * @param Request $request
     * @return Response
     */
    public function show(Request $request) : Response
    {
        $id = $request->getAttribute('id');
        $slug = $request->getAttribute('slug');
        $post = $this->postTable->find($id);

        if ($post->slug !== $slug) {
            return $this->redirect('blog.show', [
                'id' => $post->id,
                'slug' => $post->slug,
            ]);
        }

        return $this->render('@blog/show', compact('post'));
    }
}
