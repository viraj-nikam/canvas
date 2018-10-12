<?php

namespace Canvas\Repositories\Eloquent;

use Canvas\Entities\Tag;
use Canvas\Interfaces\TagInterface;

class TagRepository extends EloquentAbstract implements TagInterface
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
}
