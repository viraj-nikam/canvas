<?php

namespace Canvas\Tests\Listeners;

use Canvas\Listeners\CaptureVisit;
use Canvas\Post;
use Canvas\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ReflectionException;

class CaptureVisitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The listener instance.
     *
     * @var CaptureVisit
     */
    protected $instance;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->instance = new CaptureVisit();
    }

    /**
     * A post visit can be evaluated as unique.
     *
     * @throws ReflectionException
     * @return void
     */
    public function test_unique_post_visit()
    {
        $post = factory(Post::class)->create();
        $ip = '127.0.0.1';

        $this->invokeMethod($this->instance, 'storeInSession', [$post, $ip]);

        $response = $this->invokeMethod($this->instance, 'visitIsUnique', [$post, $ip]);

        $this->assertFalse($response);
        $this->assertArrayHasKey($post->id, session()->get('visited_posts'));

        session()->flush();

        $response = $this->invokeMethod($this->instance, 'visitIsUnique', [$post, $ip]);

        $this->assertTrue($response);
    }

    /**
     * A post visit can be stored in session.
     *
     * @throws ReflectionException
     * @return void
     */
    public function test_visited_post_stored_in_session()
    {
        $post = factory(Post::class)->create();
        $ip = '127.0.0.1';

        $this->invokeMethod($this->instance, 'storeInSession', [$post, $ip]);

        $this->assertArrayHasKey($post->id, session()->get('visited_posts'));
    }
}
