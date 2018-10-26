<?php

namespace Canvas\Tests\Unit;

use Canvas\Entities\Post;
use Canvas\Tests\TestCase;
use Faker\Factory as Faker;
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
    public function it_can_create_a_published_post()
    {
        $post = $this->createDefaultPostForUser($this->testUser->id);
        $post->published_at = now()->toDateTimeString();

        $this->assertNotNull(Post::where('title', $post->title));
        $this->assertTrue($post->published);
    }

    /** @test */
    public function it_can_create_a_draft_post()
    {
        $post = $this->createDefaultPostForUser($this->testUser->id);
        $post->published_at = now()->addDays(3)->toDateTimeString();

        $this->assertNotNull(Post::where('title', $post->title));
        $this->assertFalse($post->published);
    }

    /** @test */
    public function it_is_retrievable_by_id()
    {
        $post = $this->createDefaultPostForUser($this->testUser->id);
        $post_by_id = Post::find($post->id);

        $this->assertEquals($post->id, $post_by_id->id);
    }

    /** @test */
    public function is_can_retrieve_all_posts_for_a_user()
    {
        $post_1 = $this->createDefaultPostForUser($this->testUser->id);
        $post_2 = $this->createDefaultPostForUser($this->testUser->id);
        $post_3 = $this->createDefaultPostForUser($this->testUser->id);

        $this->assertCount(3, app(PostInterface::class)->getByUserId($this->testUser->id));
    }

    /**
     * @param $id
     * @return Post
     */
    private function createDefaultPostForUser($id): Post
    {
        return Post::create([
            'user_id'      => $id,
            'title'        => Faker::create()->sentence,
            'summary'      => Faker::create()->sentence(),
            'body'         => Faker::create()->text,
            'slug'         => Faker::create()->slug,
            'published_at' => now()->toDateTimeString(),
        ]);
    }
}
