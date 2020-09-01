<?php

namespace Canvas\Tests\Models;

use Canvas\Http\Middleware\Session;
use Canvas\Models\PostsTags;
use Canvas\Tests\TestCase;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class PostsTagsTest.
 *
 * @covers \Canvas\Models\PostsTags
 */
class PostsTagsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware([
            Authorize::class,
            Session::class,
            VerifyCsrfToken::class,
        ]);
    }

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
