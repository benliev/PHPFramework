<?php


namespace App\Blog\Entity;

/**
 * Class Post
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package App\Blog\Entity
 */
class Post
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $slug;

    /**
     * @var string
     */
    public $content;

    /**
     * @var \DateTime
     */
    public $updated_at;

    /**
     * @var \DateTime
     */
    public $created_at;

    public function __construct()
    {
        if ($this->created_at) {
            $this->created_at = new \DateTime($this->created_at);
        }
        if ($this->updated_at) {
            $this->updated_at = new \DateTime($this->updated_at);
        }
    }
}
