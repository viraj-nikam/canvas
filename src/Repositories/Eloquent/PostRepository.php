<?php

namespace Canvas\Repositories\Eloquent;

use Canvas\Entities\Post;
use Canvas\Interfaces\PostInterface;

class PostRepository extends EloquentAbstract implements PostInterface
{
    /**
     * @var Post
     */
    protected $model;

    /**
     * PostRepository constructor.
     *
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->model = $post;
    }
}
