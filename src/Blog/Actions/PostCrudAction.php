<?php

namespace App\Blog\Actions;

use App\Blog\Entity\Post;
use App\Blog\Table\PostTable;
use Framework\Actions\CrudAction;
use Framework\Renderer\RendererInterface;
use Framework\Routing\Router;
use Framework\Session\FlashService;
use Framework\Validation\Validator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class PostCrudAction
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 */
class PostCrudAction extends CrudAction
{

    /**
     * PostCrudAction constructor.
     * @param RendererInterface $renderer
     * @param PostTable $table
     * @param Router $router
     * @param FlashService $flash
     */
    public function __construct(
        RendererInterface $renderer,
        PostTable $table,
        Router $router,
        FlashService $flash
    ) {
        parent::__construct($renderer, $table, $router, $flash);
    }


    /**
     * @param Request $request
     * @return array
     */
    protected function getParams(Request $request) : array
    {
        $params = array_filter($request->getParsedBody(), function ($key) {
            return in_array($key, ['name', 'content', 'slug', 'created_at']);
        }, ARRAY_FILTER_USE_KEY);
        $params = array_merge($params, [
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        return $params;
    }

    /**
     * Make a validator
     * @param Request $request
     * @return Validator
     */
    protected function getValidator(Request $request) : Validator
    {
        return (new Validator($request->getParsedBody()))
            ->required('content', 'name', 'slug', 'created_at')
            ->length('content', 10)
            ->length('name', 2, 250)
            ->length('slug', 2, 50)
            ->slug('slug')
            ->dateTime('created_at');
    }

    /**
     * Return the view path
     * @return string
     */
    protected function getViewPath(): string
    {
        return '@blog/admin/posts';
    }

    /**
     * Get the route prefix
     * @return string
     */
    protected function getRoutePrefix(): string
    {
        return 'blog.admin.posts';
    }

    /**
     * Get flash messages
     * @return array
     */
    protected function getMessages(): array
    {
        return [
           'create' => "L'article a bien été créé",
           'edit' => "L'article a bien été édité"
        ];
    }

    /**
     * Create new entity
     * @return Post
     */
    protected function createNewEntity()
    {
        return new Post();
    }
}
