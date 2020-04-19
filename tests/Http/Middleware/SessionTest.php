<?php

namespace Canvas\Tests\Middleware;

use Canvas\Http\Middleware\Session;
use Canvas\Post;
use Canvas\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ReflectionException;

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
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->instance = new Session();
    }

    /**
     * Views that more than 60 minutes old are pruned from session.
     *
     * @throws ReflectionException
     * @return void
     */
    public function test_expired_views_can_be_pruned_from_session()
    {
        $post_1 = factory(Post::class)->create();
        $key_1 = 'viewed_posts.'.$post_1->id;

        session()->put($key_1, now()->timestamp);

        $post_2 = factory(Post::class)->create();
        $key_2 = 'viewed_posts.'.$post_2->id;

        session()->put($key_2, now()->subHours(2)->timestamp);

        $this->invokeMethod($this->instance, 'pruneExpiredViews', [collect(session()->get('viewed_posts'))]);

        $this->assertArrayHasKey($post_1->id, session()->get('viewed_posts'));
        $this->assertArrayNotHasKey($post_2->id, session()->get('viewed_posts'));
    }

    /**
     * Visits that more than 24 hours old are pruned from session.
     *
     * @throws ReflectionException
     * @return void
     */
    public function test_expired_visits_can_be_pruned_from_session()
    {
        $ip = '127.0.0.1';
        $post_1 = factory(Post::class)->create();
        $key_1 = 'visited_posts.'.$post_1->id;

        session()->put($key_1, [
            'timestamp' => now()->timestamp,
            'ip' => $ip,
        ]);

        $post_2 = factory(Post::class)->create();
        $key_2 = 'visited_posts.'.$post_2->id;

        session()->put($key_2, [
            'timestamp' => now()->subDay()->timestamp,
            'ip' => $ip,
        ]);

        $this->invokeMethod($this->instance, 'pruneExpiredVisits', [collect(session()->get('visited_posts'))]);

        $this->assertArrayHasKey($post_1->id, session()->get('visited_posts'));
        $this->assertArrayNotHasKey($post_2->id, session()->get('visited_posts'));
    }
}
