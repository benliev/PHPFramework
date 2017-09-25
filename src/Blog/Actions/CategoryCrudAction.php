<?php

namespace App\Blog\Actions;

use App\Blog\Entity\Category;
use App\Blog\Table\CategoryTable;
use Framework\Actions\CrudAction;
use Framework\Renderer\RendererInterface;
use Framework\Routing\Router;
use Framework\Session\FlashService;
use Framework\Validation\Validator;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class CategoryCrudAction
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package App\Blog\Actions
 */
class CategoryCrudAction extends CrudAction
{

    /**
     * CategoryCrudAction constructor.
     * @param RendererInterface $renderer
     * @param CategoryTable $table
     * @param Router $router
     * @param FlashService $flash
     */
    public function __construct (
        RendererInterface $renderer,
        CategoryTable $table,
        Router $router,
        FlashService $flash
    )
    {
        parent::__construct($renderer, $table, $router, $flash);
    }

    /**
     * Get the validator
     * @param Request $request
     * @return Validator
     */
    protected function getValidator(Request $request): Validator
    {
        return (new Validator($request->getParsedBody()))
            ->required('name', 'slug')
            ->length('name', 2, 250)
            ->length('slug', 2, 50)
            ->slug('slug');
    }

    /**
     * Return the view path
     * @return string
     */
    protected function getViewPath(): string
    {
        return '@blog/admin/categories';
    }

    /**
     * Get the route prefix
     * @return string
     */
    protected function getRoutePrefix(): string
    {
        return 'blog.admin.categories';
    }

    /**
     * Get flash messages
     * @return array
     */
    protected function getMessages(): array
    {
        return [
            'create' => 'Une nouvelle catégorie a été créé',
            'edit' => 'Une catégorie a été édité',
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function getParams(Request $request): array
    {
        return array_filter($request->getParsedBody(), function ($key) {
            return in_array($key, ['name', 'slug']);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Create new entity
     * @return Category
     */
    protected function createNewEntity()
    {
        return new Category();
    }
}