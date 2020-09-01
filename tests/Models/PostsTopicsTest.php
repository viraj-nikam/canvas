<?php

namespace Canvas\Tests\Models;

use Canvas\Http\Middleware\Session;
use Canvas\Models\PostsTopics;
use Canvas\Tests\TestCase;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class PostsTopicsTest.
 *
 * @covers \Canvas\Models\PostsTopics
 */
class PostsTopicsTest extends TestCase
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
        $this->assertInstanceOf(BelongsTo::class, resolve(PostsTopics::class)->posts());
    }

    /** @test */
    public function topic_relationship()
    {
        $this->assertInstanceOf(BelongsTo::class, resolve(PostsTopics::class)->topic());
    }
}
