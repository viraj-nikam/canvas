<?php

namespace Canvas\Tests\Events;

use Canvas\Events\PostViewed;
use Canvas\Models\Post;
use Canvas\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostViewedEventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_new_event()
    {
        $post = factory(Post::class)->create();

        $event = new PostViewed($post);

        $this->assertSame($post, $event->post);
    }
}
