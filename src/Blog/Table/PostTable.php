<?php


namespace App\Blog\Table;

use App\Blog\Entity\Post;
use Framework\Database\PaginatedQuery;
use Pagerfanta\Pagerfanta;

/**
 * Class PostTable
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package App\Blog\Table
 */
class PostTable
{

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * PostTable constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Paginate posts
     * @param int $maxPerPage
     * @param int $currentPage
     * @return Pagerfanta
     */
    public function findPaginated(int $maxPerPage, int $currentPage): Pagerfanta
    {
        $query = new PaginatedQuery(
            $this->pdo,
            "SELECT * FROM posts",
            "SELECT COUNT(id) FROM posts",
            Post::class
        );
        return (new Pagerfanta($query))
            ->setMaxPerPage($maxPerPage)
            ->setCurrentPage($currentPage);
    }

    /**
     * Find a post with id
     * @param int $id
     * @return Post
     */
    public function find(int $id) : ?Post
    {
        $query = $this->pdo->prepare('SELECT * FROM posts WHERE id = ?');
        $query->execute([$id]);
        $query->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        return $query->fetch() ?: null;
    }

    /**
     * Update a record
     * @param int $id
     * @param array $fields
     * @return bool
     */
    public function update(int $id, array $fields): bool
    {
        $sql = 'UPDATE posts SET';
        foreach ($fields as $field => $value) {
            $sql .= ' $field = :$field';
        }
        return true;
    }
}
