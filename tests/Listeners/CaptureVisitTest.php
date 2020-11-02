<?php

namespace Canvas\Tests\Listeners;

use Canvas\Events\PostViewed;
use Canvas\Listeners\CaptureVisit;
use Canvas\Models\Post;
use Canvas\Tests\TestCase;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class CaptureVisitTest.
 *
 * @covers \Canvas\Listeners\CaptureVisit
 */
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
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->instance = new CaptureVisit();
    }

    public function testVisitsCanBeCaptured(): void
    {
        $post = factory(Post::class)->create();

        $event = new PostViewed($post);

        $listener = new CaptureVisit();

        $listener->handle($event);

        $this->assertDatabaseHas('canvas_visits', [
            'post_id' => $post->id,
        ]);
    }

    public function testUniqueVisitsCanBeVerified(): void
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

    public function testPostCanBeSuccessfullyStoredInSession(): void
    {
        $post = factory(Post::class)->create();

        $ip = '127.0.0.1';

        $this->invokeMethod($this->instance, 'storeInSession', [$post, $ip]);

        $this->assertArrayHasKey($post->id, session()->get('visited_posts'));
    }
}
