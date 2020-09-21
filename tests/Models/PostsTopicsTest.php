<?php

namespace Canvas\Tests\Models;

use Canvas\Models\PostsTopics;
use Canvas\Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class PostsTopicsTest.
 *
 * @covers \Canvas\Models\PostsTopics
 */
class PostsTopicsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function posts_relationship()
    {
        $this->assertInstanceOf(BelongsTo::class, resolve(PostsTopics::class)->posts());
    }

    /** @test */
    public function topic_relationship()
    {
        $this->assertInstanceOf(BelongsTo::class, resolve(PostsTopics::class)->topic());
    }
}
