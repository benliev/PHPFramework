<?php

namespace App\Blog\Actions;

use App\Blog\Table\PostTable;
use Framework\Actions\RendererAwareAction;
use Framework\Actions\RouterAwareAction;
use Framework\Renderer\RendererInterface;
use Framework\Routing\Router;
use Framework\Session\FlashService;
use Framework\Session\SessionInterface;
use Framework\Validation\Validator;
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
     * @var SessionInterface
     */
    private $session;

    /**
     * @var FlashService
     */
    private $flash;

    /**
     * BlogAction constructor.
     * @param RendererInterface $renderer
     * @param PostTable $postTable
     * @param Router $router
     * @param FlashService $flash
     */
    public function __construct(
        RendererInterface $renderer,
        PostTable $postTable,
        Router $router,
        FlashService $flash
    ) {
    
        $this->renderer = $renderer;
        $this->router = $router;
        $this->postTable = $postTable;
        $this->flash = $flash;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request) : Response
    {
        if ($request->getMethod() === 'DELETE') {
            $this->delete($request);
        }
        if (substr((string)$request->getUri(), -3) === 'new') {
            return $this->create($request);
        }
        if ($request->getAttribute('id')) {
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
            $params = $this->getParams($request);
            $params['updated_at'] = date('Y-m-d H:i:s');
            $validator = $this->makeValidator($request);
            if ($validator->isValid()) {
                $this->postTable->update($item->id, $params);
                $this->flash->success('L\'article a bien été mis à jour');
                return $this->redirect('admin.blog.index');
            }
            $params['id'] = $item->id;
            $item = $params;
            $errors = $validator->getErrors();
        }

        return $this->render('@blog/admin/edit', compact('item', 'errors'));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        if ($request->getMethod() === 'POST') {
            $params = $this->getParams($request);
            $params['updated_at'] = date('Y-m-d H:i:s');
            $params['created_at'] = date('Y-m-d H:i:s');
            $validator = $this->makeValidator($request);
            if ($validator->isValid()) {
                $this->postTable->insert($params);
                $this->flash->success('L\'article a bien été créer');
                return $this->redirect('admin.blog.index');
            }
            $item = $params;
            $errors = $validator->getErrors();
        }

        return $this->render('@blog/admin/create', compact('item', 'errors'));
    }

    /**
     * @param Request $request
     * @return array
     */
    private function getParams(Request $request) : array
    {
        return array_filter($request->getParsedBody(), function ($key) {
            return in_array($key, ['name', 'content', 'slug']);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function delete(Request $request)
    {
        $this->postTable->delete($request->getAttribute('id'));
        return $this->redirect('blog.admin.index');
    }

    /**
     * Make a validator
     * @param Request $request
     * @return Validator
     */
    private function makeValidator(Request $request) : Validator
    {
        return (new Validator($request->getParsedBody()))
            ->required('content', 'name', 'slug')
            ->length('content', 10)
            ->length('name', 2, 250)
            ->length('slug', 2, 50)
            ->slug('slug');
    }
}
