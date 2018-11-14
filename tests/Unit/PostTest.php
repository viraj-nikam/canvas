<?php

namespace Canvas\Tests\Unit;

use Canvas\Post;
use Canvas\Tests\TestCase;
use Faker\Factory as Faker;

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
    public function it_can_create_a_published_post()
    {
        $post = $this->createPostForUser($this->testUser->id);
        $post->published_at = now()->toDateTimeString();

        $this->assertNotNull(Post::where('title', $post->title));
        $this->assertTrue($post->published);
    }

    /** @test */
    public function it_can_create_a_draft_post()
    {
        $post = $this->createPostForUser($this->testUser->id);
        $post->published_at = now()->addDays(3)->toDateTimeString();

        $this->assertNotNull(Post::where('title', $post->title));
        $this->assertFalse($post->published);
    }

    /** @test */
    public function it_is_retrievable_by_id()
    {
        $post = $this->createPostForUser($this->testUser->id);
        $post_by_id = Post::find($post->id);

        $this->assertEquals($post->id, $post_by_id->id);
    }

    /** @test */
    public function it_can_soft_delete_a_post()
    {
        $post = $this->createPostForUser($this->testUser->id);
        $post->delete();

        $this->assertSoftDeleted($post);
    }

    /**
     * Get test data to create post.
     *
     * @param int $userId User ID
     *
     * @return Post
     */
    private function createPostForUser(int $userId): Post
    {
        return Post::create([
            'id'           => Faker::create()->uuid,
            'slug'         => sprintf('%s-%s', 'post', Faker::create()->uuid),
            'title'        => Faker::create()->sentence,
            'summary'      => Faker::create()->sentence(),
            'body'         => Faker::create()->text,
            'published_at' => now()->toDateTimeString(),
            'user_id'      => $userId,
        ]);
    }
}
