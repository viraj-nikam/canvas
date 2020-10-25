<?php

namespace Canvas\Tests\Listeners;

use Canvas\Events\PostViewed;
use Canvas\Listeners\CaptureView;
use Canvas\Models\Post;
use Canvas\Tests\TestCase;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class CaptureViewTest.
 *
 * @covers \Canvas\Listeners\CaptureView
 */
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
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->instance = new CaptureView();
    }

    public function testViewsCanBeCaptured(): void
    {
        $post = factory(Post::class)->create();

        $event = new PostViewed($post);

        $listener = new CaptureView();

        $listener->handle($event);

        $this->assertDatabaseHas('canvas_views', [
            'post_id' => $post->id,
        ]);
    }

    public function testRecentlyViewedPostsCanBeVerified(): void
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

    public function testPostCanBeSuccessfullyStoredInSession(): void
    {
        $post = factory(Post::class)->create();

        $this->invokeMethod($this->instance, 'storeInSession', [$post]);

        $this->assertArrayHasKey($post->id, session()->get('viewed_posts'));
    }
}
