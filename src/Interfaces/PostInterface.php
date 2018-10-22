<?php

namespace Canvas\Interfaces;

use Canvas\Entities\Post;
use Illuminate\Support\Collection;

interface PostInterface extends InterfaceAbstract
{
    /**
     * @return Collection|null
     */
    public function getPublished(): ?Collection;

    /**
     * @param string $user_id
     * @return Collection|null
     */
    public function getByUserId(string $user_id): ?Collection;

    /**
     * @param string $slug
     * @return Post|null
     */
    public function findBySlug(string $slug): ?Post;
}
