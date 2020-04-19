<?php

namespace Canvas\Tests\Listeners;

use Canvas\Listeners\CaptureView;
use Canvas\Post;
use Canvas\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ReflectionException;

class CaptureViewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The listener instance.
     *
     * @var CaptureView
     */
    protected $instance;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->instance = new CaptureView();
    }

    /**
     * Check if a post was recently viewed.
     *
     * @throws ReflectionException
     * @return void
     */
    public function test_recently_viewed()
    {
        $post = factory(Post::class)->create();

        $this->invokeMethod($this->instance, 'storeInSession', [$post]);

        $response = $this->invokeMethod($this->instance, 'wasRecentlyViewed', [$post]);

        $this->assertTrue($response);
        $this->assertArrayHasKey($post->id, session()->get('viewed_posts'));

        session()->flush();

        $response = $this->invokeMethod($this->instance, 'wasRecentlyViewed', [$post]);

        $this->assertFalse($response);
    }

    /**
     * A post view can be stored in session.
     *
     * @throws ReflectionException
     * @return void
     */
    public function test_viewed_post_stored_in_session()
    {
        $post = factory(Post::class)->create();

        $this->invokeMethod($this->instance, 'storeInSession', [$post]);

        $this->assertArrayHasKey($post->id, session()->get('viewed_posts'));
    }
}
