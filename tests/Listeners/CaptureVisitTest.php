<?php

namespace Canvas\Tests\Listeners;

use Canvas\Listeners\CaptureVisit;
use Canvas\Post;
use Canvas\Tests\TestCase;

class CaptureVisitTest extends TestCase
{
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

    /** @test */
    public function check_if_a_post_evaluates_unique_visits()
    {
        $post = factory(Post::class)->create();

        $key = 'visited_posts.'.$post->id;

        session()->put($key, time());

        $response = $this->invokeMethod($this->instance, 'visitIsUnique', ['post' => $post]);

        $this->assertFalse($response);
        $this->assertArrayHasKey($post->id, session()->get('visited_posts'));

        session()->flush();

        $response = $this->invokeMethod($this->instance, 'visitIsUnique', ['post' => $post]);

        $this->assertTrue($response);
    }

    /** @test */
    public function store_a_post_id_in_session()
    {
        $post = factory(Post::class)->create();

        $this->invokeMethod($this->instance, 'storeInSession', ['post' => $post]);

        $this->assertArrayHasKey($post->id, session()->get('visited_posts'));
    }
}
