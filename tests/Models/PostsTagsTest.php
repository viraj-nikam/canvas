<?php

namespace Canvas\Tests\Models;

use Canvas\Models\PostsTags;
use Canvas\Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class PostsTagsTest.
 *
 * @covers \Canvas\Models\PostsTags
 */
class PostsTagsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function posts_relationship()
    {
        $this->assertInstanceOf(BelongsTo::class, resolve(PostsTags::class)->posts());
    }

    /** @test */
    public function tags_relationship()
    {
        $this->assertInstanceOf(BelongsTo::class, resolve(PostsTags::class)->tags());
    }
}
