<?php

namespace Canvas\Repositories\Eloquent;

use Canvas\Entities\Post;
use Illuminate\Support\Collection;
use Canvas\Interfaces\PostInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PostRepository extends RepositoryAbstract implements PostInterface
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

    /**
     * @return Collection
     */
    public function getPublished(): Collection
    {
        return $this->model->where('published_at', '<=', now()->toDateTimeString())->get();
    }

    /**
     * @param string $userId
     * @return Collection
     */
    public function getByUserId(string $userId): Collection
    {
        return $this->model->where('user_id', $userId)->get();
    }

    /**
     * @param string $slug
     * @throws ModelNotFoundException
     * @return Post
     */
    public function findBySlug(string $slug): Post
    {
        return $this->model->where('slug', $slug)->firstOrFail();
    }
}
