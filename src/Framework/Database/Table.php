<?php


namespace Framework\Database;
use Pagerfanta\Pagerfanta;

/**
 * Class Table
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework\Database
 */
abstract class Table
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
            $this->paginationQuery(),
            "SELECT COUNT(id) FROM {$this->getTable()}",
            $this->getEntity()
        );
        return (new Pagerfanta($query))
            ->setMaxPerPage($maxPerPage)
            ->setCurrentPage($currentPage);
    }

    /**
     * Query for pagination
     * @return string
     */
    protected function paginationQuery ()
    {
        return "SELECT * FROM {$this->getTable()}";
    }

    /**
     * Find a record with id
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        $query = $this->pdo->prepare("SELECT * FROM {$this->getTable()} WHERE id = ?");
        $query->execute([$id]);
        /** @noinspection PhpMethodParametersCountMismatchInspection */
        $query->setFetchMode(\PDO::FETCH_CLASS, $this->getEntity());
        return $query->fetch() ?: null;
    }

    /**
     * Return an array with key is id and value is name
     */
    public function findList(): array
    {
        return array_map(
            function($result) { return [$result[0] => $result[1]]; },
            $this->pdo
                ->query("SELECT 'id', 'name' FROM {$this->getTable()}")
                ->fetchAll(\PDO::FETCH_NUM)
        );
    }

    /**
     * Update a record
     * @param int $id
     * @param array $params
     * @return bool
     */
    public function update(int $id, array $params): bool
    {
        $fieldQuery = join(', ', array_map(function ($field) { return "$field = :$field"; }, array_keys($params)));
        $params["id"] = $id;
        $statement = $this->pdo->prepare(
            "UPDATE {$this->getTable()} SET $fieldQuery WHERE id = :id"
        );
        return $statement->execute($params);
    }

    /**
     * Insert a record
     * @param array $params
     * @return bool
     */
    public function insert(array $params): bool
    {
        $fields = join(',', array_keys($params));
        $values = join(',', array_map(function ($field) { return ":$field"; }, array_keys($params)));
        $statement = $this->pdo->prepare("INSERT INTO {$this->getTable()} ({$fields}) values ({$values})");
        return $statement->execute($params);
    }

    /**
     * Delete a record
     * @param int $id
     * @return bool
     */
    public function delete(int $id) : bool
    {
        return $this->pdo->prepare("DELETE FROM {$this->getTable()} WHERE id = ?")->execute([$id]);
    }

    /**
     * Get the table name in database
     * @return string
     */
    public abstract function getTable(): string;

    /**
     * Get the entity to fetch
     * @return string
     */
    public abstract function getEntity(): string;
}