<?php

namespace Canvas;

trait Helpers
{
    /**
     * Return true if the given ID is for a new resource.
     *
     * @param string $id
     * @return bool
     */
    public function isFresh(string $id): bool
    {
        return $id === 'create';
    }
}
