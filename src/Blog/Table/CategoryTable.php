<?php

namespace App\Blog\Table;

use App\Blog\Entity\Category;
use Framework\Database\Table;

/**
 * Class CategoryTable
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package App\Blog\Table
 */
class CategoryTable extends Table
{

    /**
     * Get the table name in database
     * @return string
     */
    public function getTable(): string
    {
        return 'categories';
    }

    /**
     * Get the entity to fetch
     * @return string
     */
    public function getEntity(): string
    {
        return Category::class;
    }
}