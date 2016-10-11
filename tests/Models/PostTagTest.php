<?php

use EGALL\EloquentPHPUnit\EloquentTestCase;

class PostTagTest extends EloquentTestCase
{
    /**
     * The user model's full namespace.
     *
     * @var string
     */
    protected $model = 'App\Models\PostTag';

    /**
     * Disable database seeding.
     *
     * @var bool
     */
    protected $seedDatabase = false;

    /** @test */
    public function it_has_the_correct_model_properties()
    {
        $this->hasFillable(['post_id', 'tag_id', 'created_at', 'updated_at']);
    }
}
