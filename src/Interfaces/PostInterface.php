<?php

namespace Canvas\Interfaces;

use Illuminate\Support\Collection;

interface PostInterface extends InterfaceAbstract
{
    /**
     * @param string $user_id
     * @return Collection
     */
    public function getByUserId(string $user_id): Collection;
}
