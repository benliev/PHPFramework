<?php

namespace Framework\Actions;
use Framework\Database\Table;
use Framework\Renderer\RendererInterface;
use Framework\Routing\Router;
use Framework\Session\FlashService;
use Framework\Validation\Validator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class CrudAction
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework\Actions
 */
abstract class CrudAction
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
     * @var Table
     */
    private $table;

    /**
     * @var FlashService
     */
    private $flash;

    /**
     * CrudAction constructor.
     * @param RendererInterface $renderer
     * @param Table $table
     * @param Router $router
     * @param FlashService $flash
     */
    public function __construct(
        RendererInterface $renderer,
        Table $table,
        Router $router,
        FlashService $flash
    ) {
        $this->renderer = $renderer;
        $this->router = $router;
        $this->table = $table;
        $this->flash = $flash;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request) : Response
    {
        $this->renderer->addGlobal('viewPath', $this->getViewPath());
        $this->renderer->addGlobal('routePrefix', $this->getRoutePrefix());
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
     * Display items
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) : Response
    {
        $params = $request->getQueryParams();
        $items = $this->table->findPaginated(10, $params['page'] ?? 1);
        return $this->render("{$this->getViewPath()}/index", compact('items'));
    }

    /**
     * Display one item
     * @param Request $request
     * @return Response
     */
    public function edit(Request $request) : Response
    {
        $item = $this->table->find($request->getAttribute('id'));
        if ($request->getMethod() === 'PUT') {
            $params = $this->getParams($request);
            $validator = $this->getValidator($request);
            if ($validator->isValid()) {
                $this->table->update($item->id, $params);
                $this->flash->success($this->getMessages()['edit']);
                return $this->redirect("{$this->getRoutePrefix()}.index");
            }
            $errors = $validator->getErrors();
            $params['id'] = $item->id;
            $item = $params;
        }

        return $this->render("{$this->getViewPath()}/edit", compact('item', 'errors'));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $item = $this->createNewEntity();
        if ($request->getMethod() === 'POST') {
            $params = $this->getParams($request);
            $validator = $this->getValidator($request);
            if ($validator->isValid()) {
                $this->table->insert($params);
                $this->flash->success($this->getMessages()['create']);
                return $this->redirect('admin.blog.index');
            }
            $item = $params;
            $errors = $validator->getErrors();
        }

        return $this->render("{$this->getViewPath()}/create", compact('item', 'errors'));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function delete(Request $request)
    {
        $this->table->delete($request->getAttribute('id'));
        return $this->redirect('blog.admin.index');
    }

    /**
     * Get the validator
     * @param Request $request
     * @return Validator
     */
    protected abstract function getValidator(Request $request) : Validator;

    /**
     * Return the view path
     * @return string
     */
    protected abstract function getViewPath(): string;

    /**
     * Get the route prefix
     * @return string
     */
    protected abstract function getRoutePrefix(): string;

    /**
     * Get flash messages
     * @return array
     */
    protected abstract function getMessages(): array;

    /**
     * @param Request $request
     * @return array
     */
    protected abstract function getParams(Request $request) : array;

    /**
     * Create new entity
     * @return mixed
     */
    protected abstract function createNewEntity();
}