<?php

namespace Test\Blog\Table;

use App\Blog\Entity\Post;
use App\Blog\Table\PostTable;
use PDO;
use Tests\DatabaseTestCase;

/**
 * Class PostTableTest
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 */
class PostTableTest extends DatabaseTestCase
{
    /**
     * @var PostTable
     */
    private $postTable;

    public function setUp()
    {
        parent::setUp();
        $this->postTable = new PostTable($this->pdo);
    }

    public function testFind()
    {
        $post = $this->postTable->find(1);
        $this->assertInstanceOf($post, Post::class);
    }

    public function testFindUnknowRecord()
    {
        $post = $this->postTable->find(1000);
        $this->assertNull($post);
    }

    public function testUpdate()
    {
        $this->postTable->update(1, ['name' => 'salut', 'slug' => 'demo']);
        $post = $this->postTable->find(1);
        $this->assertEquals('salut', $post->name);
        $this->assertEquals('demo', $post->slug);
    }
}
