<?php

namespace Canvas\Tests\Http\Middleware;

use Canvas\Http\Middleware\Session;
use Canvas\Models\Post;
use Canvas\Tests\TestCase;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;

/**
 * Class SessionTest.
 *
 * @covers \Canvas\Http\Middleware\Session
 */
class SessionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The middleware instance.
     *
     * @var Session
     */
    protected $instance;

    /**
     * @return void
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->instance = new Session();
    }

    public function testViewedPostsCanBeFetchedFromSession(): void
    {
        $post = factory(Post::class)->create();

        session()->put('viewed_posts.'.$post->id, now()->timestamp);

        $response = $this->invokeMethod($this->instance, 'getViewedPostsInSession');

        $this->assertInstanceOf(Collection::class, $response);

        $this->assertArrayHasKey($post->id, session()->get('viewed_posts'));
    }

    public function testVisitedPostsCanBeFetchedFromSession(): void
    {
        $post = factory(Post::class)->create();

        session()->put('viewed_posts.'.$post->id, now()->timestamp);

        $response = $this->invokeMethod($this->instance, 'getVisitedPostsInSession');

        $this->assertInstanceOf(Collection::class, $response);

        $this->assertArrayHasKey($post->id, session()->get('viewed_posts'));
    }

    public function testViewsCanBePrunedFromSession(): void
    {
        $recentPost = factory(Post::class)->create();

        session()->put('viewed_posts.'.$recentPost->id, now()->timestamp);

        $oldPost = factory(Post::class)->create();

        session()->put('viewed_posts.'.$oldPost->id, now()->subHour()->subMinute()->timestamp);

        $this->invokeMethod($this->instance, 'pruneExpiredViews', [
            collect(session()->get('viewed_posts')),
        ]);

        $this->assertArrayHasKey($recentPost->id, session()->get('viewed_posts'));
        $this->assertArrayNotHasKey($oldPost->id, session()->get('viewed_posts'));
    }

    public function testVisitsCanBePrunedFromSession(): void
    {
        $ip = '127.0.0.1';

        $recentPost = factory(Post::class)->create();

        session()->put('visited_posts.'.$recentPost->id, [
            'timestamp' => now()->timestamp,
            'ip' => $ip,
        ]);

        $oldPost = factory(Post::class)->create();

        session()->put('visited_posts.'.$oldPost->id, [
            'timestamp' => now()->subDay()->timestamp,
            'ip' => $ip,
        ]);

        $this->invokeMethod($this->instance, 'pruneExpiredVisits', [
            collect(session()->get('visited_posts')),
        ]);

        $this->assertArrayHasKey($recentPost->id, session()->get('visited_posts'));
        $this->assertArrayNotHasKey($oldPost->id, session()->get('visited_posts'));
    }
}
