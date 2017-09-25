<?php

namespace App\Blog\Table;

use App\Blog\Entity\Post;
use Framework\Database\Table;

/**
 * Class PostTable
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package App\Blog\Table
 */
class PostTable extends Table
{

    /**
     * Get the table name in database
     * @return string
     */
    public function getTable(): string
    {
        return 'posts';
    }

    /**
     * Get the entity to fetch
     * @return string
     */
    public function getEntity(): string
    {
        return Post::class;
    }

    /**
     * Query for pagination
     * @return string
     */
    protected function paginationQuery()
    {
        return "select p.*, c.name AS category_name
          FROM {$this->getTable()} AS p
          LEFT JOIN categories AS c ON p.category_id = c.id
          ORDER BY created_at DESC";
    }
}
