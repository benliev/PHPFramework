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
     * Paginate records
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
     * Find a record with id
     * @param int $id
     * @return Post
     */
    public function find(int $id) : ?Post
    {
        $query = $this->pdo->prepare('SELECT * FROM posts WHERE id = ?');
        $query->execute([$id]);
        /** @noinspection PhpMethodParametersCountMismatchInspection */
        $query->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        return $query->fetch() ?: null;
    }

    /**
     * Update a record
     * @param int $id
     * @param array $params
     * @return bool
     */
    public function update(int $id, array $params): bool
    {
        $fieldQuery = $this->buildFieldQuery($params);
        $params["id"] = $id;
        $statement = $this->pdo->prepare("UPDATE posts SET $fieldQuery WHERE id = :id");
        return $statement->execute($params);
    }

    /**
     * Insert a record
     * @param array $params
     * @return bool
     */
    public function insert(array $params): bool
    {
        $fields = array_keys($params);
        $values = array_map(function ($field) {
            return ":$field";
        }, $fields);
        $statement = $this->pdo->prepare(
            "INSERT INTO posts (".join(",", $fields).") values (".join(",", $values).")"
        );
        return $statement->execute($params);
    }

    /**
     * Delete a record
     * @param int $id
     * @return bool
     */
    public function delete(int $id) : bool
    {
        return $this->pdo->prepare('DELETE FROM posts WHERE id = ?')
            ->execute([$id]);
    }

    /**
     * Build field query
     * @param array $params
     * @return string
     */
    private function buildFieldQuery(array $params) : string
    {
        return join(', ', array_map(function ($field) {
            return "$field = :$field";
        }, array_keys($params)));
    }
}
