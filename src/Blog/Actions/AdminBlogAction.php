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
class AdminBlogAction
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
            return $this->edit($request);
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
        $items = $this->postTable->findPaginated(10, $params['page'] ?? 1);
        return $this->render('@blog/admin/index', compact('items'));
    }

    /**
     * Display one post
     * @param Request $request
     * @return Response
     */
    public function edit(Request $request) : Response
    {
        $item = $this->postTable->find($request->getAttribute('id'));

        if ($request->getMethod() === 'POST') {
        }

        return $this->render('@blog/admin/edit', compact('item'));
    }
}
