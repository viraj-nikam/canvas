<?php

namespace Canvas\Tests\Models;

use Canvas\Models\Post;
use Canvas\Models\Topic;
use Canvas\Models\User;
use Canvas\Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Ramsey\Uuid\Uuid;

/**
 * Class TopicTest.
 *
 * @covers \Canvas\Models\Topic
 */
class TopicTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testTopicsCanShareTheSameSlugWithUniqueUsers(): void
    {
        $adminUserOne = factory(User::class)->create([
            'role' => User::ADMIN,
        ]);

        $topicOneData = [
            'id' => Uuid::uuid4()->toString(),
            'name' => 'A new topic',
            'slug' => 'a-new-topic',
        ];

        $topicOne = factory(Topic::class)->create();

        $response = $this->actingAs($adminUserOne, 'canvas')->postJson("/canvas/api/topics/{$topicOne->id}", $topicOneData);

        $this->assertDatabaseHas('canvas_topics', [
            'id' => $response->original['id'],
            'slug' => $response->original['slug'],
            'user_id' => $response->original['user_id'],
        ]);

        $adminUserTwo = factory(User::class)->create([
            'role' => User::ADMIN,
        ]);

        $topicTwoData = [
            'id' => Uuid::uuid4()->toString(),
            'name' => 'A new topic',
            'slug' => 'a-new-topic',
        ];

        $topicTwo = factory(Topic::class)->create();

        $response = $this->actingAs($adminUserTwo, 'canvas')->postJson("/canvas/api/topics/{$topicTwo->id}", $topicTwoData);

        $this->assertDatabaseHas('canvas_topics', [
            'id' => $response->original['id'],
            'slug' => $response->original['slug'],
            'user_id' => $response->original['user_id'],
        ]);
    }

    public function testPostsRelationship(): void
    {
        $topic = factory(Topic::class)->create();
        $post = factory(Post::class)->create();

        $post->topic()->sync($topic);

        $this->assertCount(1, $post->topic);
        $this->assertInstanceOf(BelongsToMany::class, $topic->posts());
        $this->assertInstanceOf(Post::class, $topic->posts->first());
    }

    public function testUserRelationship(): void
    {
        $topic = factory(Topic::class)->create();

        $this->assertInstanceOf(BelongsTo::class, $topic->user());
        $this->assertInstanceOf(User::class, $topic->user);
    }

    public function testDetachPostsOnDelete(): void
    {
        $topic = factory(Topic::class)->create();
        $post = factory(Post::class)->create();

        $topic->posts()->sync([$post->id]);

        $topic->delete();

        $this->assertEquals(0, $topic->posts->count());
        $this->assertDatabaseMissing('canvas_posts_topics', [
            'post_id' => $post->id,
            'topic_id' => $topic->id,
        ]);
    }
}
