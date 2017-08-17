<?php

namespace Tests;

use Canvas\Models\User;

trait CreatesUser
{
    /**
     * The User model.
     *
     * @var User
     */
    private $user;

    /**
     * Create the User model test subject.
     *
     * @before
     * @return void
     */
    public function createUser()
    {
        $this->user = factory(User::class)->create();
    }
}
