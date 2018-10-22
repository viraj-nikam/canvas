<?php

namespace Canvas\Interfaces;

use Canvas\Entities\Tag;

interface TagInterface extends InterfaceAbstract
{
    /**
     * @param string $slug
     * @return Tag|null
     */
    public function findBySlug(string $slug): ?Tag;
}
