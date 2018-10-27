<?php

namespace Canvas\Repositories\Eloquent;

use Canvas\Entities\Tag;
use Canvas\Interfaces\TagInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TagRepository extends RepositoryAbstract implements TagInterface
{
    /**
     * @var Tag
     */
    protected $model;

    /**
     * TagRepository constructor.
     *
     * @param Tag $tag
     */
    public function __construct(Tag $tag)
    {
        $this->model = $tag;
    }

    /**
     * @param string $slug
     * @throws ModelNotFoundException
     * @return Tag
     */
    public function findBySlug(string $slug): Tag
    {
        return $this->model->where('slug', $slug)->firstOrFail();
    }
}
