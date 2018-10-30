<?php

namespace Canvas\Interfaces;

use Canvas\Entities\Post;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface PostInterface extends InterfaceAbstract
{
    /**
     * @return Collection
     */
    public function getPublished(): Collection;

    /**
     * @param string $user_id
     * @return Collection
     */
    public function getByUserId(string $user_id): Collection;

    /**
     * @param string $slug
     * @throws ModelNotFoundException
     * @return Post
     */
    public function findBySlug(string $slug): Post;
}
