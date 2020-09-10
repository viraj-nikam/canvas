<?php

namespace Canvas\Tests\Models;

use Canvas\Models\Post;
use Canvas\Models\Tag;
use Canvas\Models\User;
use Canvas\Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Ramsey\Uuid\Uuid;

/**
 * Class TagTest.
 *
 * @covers \Canvas\Models\Tag
 */
class TagTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function tags_can_share_the_same_slug_with_unique_users()
    {
        $adminUserOne = factory(User::class)->create([
            'role' => User::ADMIN,
        ]);

        $tagOneData = [
            'id' => Uuid::uuid4()->toString(),
            'name' => 'A new tag',
            'slug' => 'a-new-tag',
        ];

        $tagOne = factory(Tag::class)->create();

        $response = $this->actingAs($adminUserOne, 'canvas')->postJson("/canvas/api/tags/{$tagOne->id}", $tagOneData);

        $this->assertDatabaseHas('canvas_tags', [
            'id' => $response->original['id'],
            'slug' => $response->original['slug'],
            'user_id' => $response->original['user_id'],
        ]);

        $adminUserTwo = factory(User::class)->create([
            'role' => User::ADMIN,
        ]);

        $tagTwoData = [
            'id' => Uuid::uuid4()->toString(),
            'name' => 'A new tag',
            'slug' => 'a-new-tag',
        ];

        $tagTwo = factory(Tag::class)->create();

        $response = $this->actingAs($adminUserTwo, 'canvas')->postJson("/canvas/api/tags/{$tagTwo->id}", $tagTwoData);

        $this->assertDatabaseHas('canvas_tags', [
            'id' => $response->original['id'],
            'slug' => $response->original['slug'],
            'user_id' => $response->original['user_id'],
        ]);
    }

    /** @test */
    public function posts_relationship()
    {
        $tag = factory(Tag::class)->create();
        $post = factory(Post::class)->create();

        $post->tags()->sync($tag);

        $this->assertCount(1, $post->tags);
        $this->assertInstanceOf(BelongsToMany::class, $tag->posts());
        $this->assertInstanceOf(Post::class, $tag->posts->first());
    }

    /** @test */
    public function user_relationship()
    {
        $tag = factory(Tag::class)->create();

        $this->assertInstanceOf(BelongsTo::class, $tag->user());
        $this->assertInstanceOf(User::class, $tag->user);
    }

    /** @test */
    public function it_will_detach_posts_on_delete()
    {
        $tag = factory(Tag::class)->create();
        $post = factory(Post::class)->create();

        $tag->posts()->sync([$post->id]);

        $tag->delete();

        $this->assertEquals(0, $tag->posts->count());
        $this->assertDatabaseMissing('canvas_posts_tags', [
            'post_id' => $post->id,
            'tag_id' => $tag->id,
        ]);
    }
}
