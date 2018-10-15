<?php

namespace Canvas\Tests\Unit;

use Canvas\Entities\Post;
use Canvas\Tests\TestCase;
use Canvas\Interfaces\PostInterface;

class PostTest extends TestCase
{
    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function it_can_create_a_post()
    {
        $post = Post::create(['title' => 'example', 'summary' => '', 'body' => '', 'user_id' => $this->testUser->id, 'published' => 1]);

        $this->assertNotNull(Post::where('title', $post->title));
    }

    /** @test */
    public function it_is_retrievable_by_id()
    {
        $post_by_id = Post::find($this->testPost->id);

        $this->assertEquals($this->testPost->id, $post_by_id->id);
    }

    /** @test */
    public function is_can_retrieve_all_posts_for_a_user()
    {
        $this->refreshTestPost();
        Post::create(['title' => 'User Post', 'summary' => '', 'body' => '', 'user_id' => $this->testUser->id, 'published' => 1]);

        $this->assertCount(2, app(PostInterface::class)->getByUserId($this->testUser->id));
    }
}
