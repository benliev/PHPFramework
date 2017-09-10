<?php

namespace Tests\Blog\Actions;

use App\Blog\Actions\BlogAction;
use App\Blog\Entity\Post;
use App\Blog\Table\PostTable;
use Framework\Renderer\RendererInterface;
use Framework\Routing\Router;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Class BlogActionTest
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Tests\Blog\Actions
 */
class BlogActionTest extends TestCase
{

    /**
     * @var BlogAction
     */
    private $action;

    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var PostTable
     */
    private $postTable;

    /**
     * @var Router
     */
    private $router;

    /**
     * @param int $id
     * @param string $slug
     * @return Post
     */
    private function makePost(int $id, string $slug) : Post
    {
        $post = new Post();
        $post->id = $id;
        $post->slug = $slug;
        return $post;
    }

    public function setUp()
    {
        $this->renderer = $this->prophesize(RendererInterface::class);
        $this->postTable = $this->prophesize(PostTable::class);
        $this->router = $this->prophesize(Router::class);
        $this->action = new BlogAction(
            $this->renderer->reveal(),
            $this->postTable->reveal(),
            $this->router->reveal()
        );
    }

    public function testShowRedirect()
    {
        $uri = '/demo2';
        $post = $this->makePost(9, "azeaze-azeaze");
        $request = (new ServerRequest('GET', '/'))
            ->withAttribute('id', $post->id)
            ->withAttribute('slug', 'demo');
        $this->router->generateUri('blog.show', [
            'slug' => $post->slug,
            'id' => $post->id,
        ])->willReturn($uri);
        $this->postTable->find($post->id)->willReturn($post);
        /** @var ResponseInterface $response */
        $response = call_user_func_array($this->action, [$request]);
        $this->assertEquals(301, $response->getStatusCode());
        $this->assertEquals([$uri], $response->getHeader('location'));
    }

    public function testShowRender()
    {
        $post = $this->makePost(9, "azeaze-azeaze");
        $request = (new ServerRequest('GET', '/'))
            ->withAttribute('id', $post->id)
            ->withAttribute('slug', $post->slug);
        $this->postTable->find($post->id)->willReturn($post);
        $this->renderer->render('@blog/show', compact('post'))->willReturn('');
        $response = call_user_func_array($this->action, [$request]);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
