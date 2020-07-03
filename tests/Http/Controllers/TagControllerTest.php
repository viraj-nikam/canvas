<?php

namespace Canvas\Tests\Http\Controllers;

use Canvas\Http\Middleware\Session;
use Canvas\Models\Post;
use Canvas\Models\Tag;
use Canvas\Tests\TestCase;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Ramsey\Uuid\Uuid;

class TagControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware([Authorize::class, Session::class, VerifyCsrfToken::class]);

        $this->registerAssertJsonExactFragmentMacro();
    }

    /** @test */
    public function tags_can_be_listed()
    {
        $userOne = factory(config('canvas.user'))->create();
        $userTwo = factory(config('canvas.user'))->create();

        $tag = factory(Tag::class)->create([
            'user_id' => $userOne->id,
            'name' => 'A new tag',
            'slug' => 'a-new-tag',
        ]);

        $this->actingAs($userOne)
             ->getJson('canvas/api/tags')
             ->assertSuccessful()
             ->assertJsonExactFragment($tag->id, 'data.0.id')
             ->assertJsonExactFragment($tag->name, 'data.0.name')
             ->assertJsonExactFragment($userOne->id, 'data.0.user_id')
             ->assertJsonExactFragment($tag->slug, 'data.0.slug')
             ->assertJsonExactFragment($tag->posts->count(), 'data.0.posts_count')
             ->assertJsonExactFragment(1, 'total');

        $this->actingAs($userTwo)
             ->getJson('canvas/api/tags')
             ->assertSuccessful()
             ->assertJsonExactFragment(0, 'total');
    }

    /** @test */
    public function tags_can_be_fetched()
    {
        // Fetch tag defaults...
        $user = factory(config('canvas.user'))->create();

        $response = $this->actingAs($user)->getJson('canvas/api/tags/create')->assertSuccessful();

        $this->assertArrayHasKey('id', $response->decodeResponseJson());

        // Fetch an existing tag...
        $user = factory(config('canvas.user'))->create();

        $tag = factory(Tag::class)->create([
            'user_id' => $user->id,
            'name' => 'A new tag',
            'slug' => 'a-new-tag',
        ]);

        $this->actingAs($user)
             ->getJson("canvas/api/tags/{$tag->id}")
             ->assertSuccessful()
             ->assertJsonExactFragment($tag->id, 'id')
             ->assertJsonExactFragment($tag->name, 'name')
             ->assertJsonExactFragment($user->id, 'user_id')
             ->assertJsonExactFragment($tag->slug, 'slug');
    }

    /** @test */
    public function it_returns_404_if_no_tag_is_found()
    {
        $user = factory(config('canvas.user'))->create();

        $this->actingAs($user)->getJson('canvas/api/tags/not-a-post')->assertNotFound();
    }

    /** @test */
    public function only_tag_owners_can_access_tags()
    {
        $userOne = factory(config('canvas.user'))->create();
        $userTwo = factory(config('canvas.user'))->create();

        $tag = factory(Tag::class)->create([
            'user_id' => $userOne->id,
            'name' => 'A tag for user 1',
            'slug' => 'a-tag-for-user-1',
        ]);

        $this->actingAs($userOne)
             ->getJson("canvas/api/tags/{$tag->id}")
             ->assertSuccessful();

        $this->actingAs($userTwo)->getJson("canvas/api/tags/{$tag->id}")->assertNotFound();
    }

    /** @test */
    public function tags_can_be_stored()
    {
        // Create a new tag...
        $user = factory(config('canvas.user'))->create();

        $data = [
            'id' => Uuid::uuid4()->toString(),
            'name' => 'A new tag',
            'slug' => 'a-new-tag',
        ];

        $this->actingAs($user)
             ->postJson("canvas/api/tags/{$data['id']}", $data)
             ->assertSuccessful()
             ->assertJsonExactFragment($data['name'], 'name')
             ->assertJsonExactFragment($data['slug'], 'slug')
             ->assertJsonExactFragment($user->id, 'user_id');

        // Update an existing tag...
        $tag = factory(Tag::class)->create([
            'name' => 'Another tag',
            'slug' => 'another-tag',
            'user_id' => $user->id,
        ]);

        $data = [
            'name' => 'An updated tag',
            'slug' => 'an-updated-tag',
        ];

        $this->actingAs($tag->user)
             ->postJson("canvas/api/tags/{$tag->id}", $data)
             ->assertSuccessful()
             ->assertJsonExactFragment($data['name'], 'name')
             ->assertJsonExactFragment($data['slug'], 'slug')
             ->assertJsonExactFragment($tag->user->id, 'user_id');
    }

    /** @test */
    public function invalid_slugs_will_not_be_stored()
    {
        $tag = factory(Tag::class)->create();

        $response = $this->actingAs($tag->user)
                         ->postJson("canvas/api/tags/{$tag->id}", [
                             'name' => 'A new tag',
                             'slug' => 'a new.slug',
                         ])
                         ->assertStatus(422);

        $this->assertArrayHasKey('slug', $response->decodeResponseJson('errors'));
    }

    /** @test */
    public function tags_can_be_deleted()
    {
        $userOne = factory(config('canvas.user'))->create();
        $userTwo = factory(config('canvas.user'))->create();

        $tag = factory(Tag::class)->create([
            'user_id' => $userOne->id,
            'name' => 'A new tag',
            'slug' => 'a-new-tag',
        ]);

        $this->actingAs($userTwo)->deleteJson("canvas/api/tags/{$tag->id}")->assertNotFound();

        $this->actingAs($userOne)->deleteJson('canvas/api/tags/not-a-tag')->assertNotFound();

        $this->actingAs($userOne)
             ->deleteJson("canvas/api/tags/{$tag->id}")
             ->assertSuccessful()
             ->assertNoContent();

        $this->assertSoftDeleted('canvas_tags', [
            'id' => $tag->id,
            'slug' => $tag->slug,
        ]);
    }

    /** @test */
    public function de_sync_post_relationship()
    {
        $user = factory(config('canvas.user'))->create();
        $tag = factory(Tag::class)->create();
        $post = factory(Post::class)->create([
            'user_id' => $user->id,
            'slug' => 'a-new-post',
        ]);

        $tag->posts()->sync([$post->id]);

        $this->assertDatabaseHas('canvas_posts_tags', [
            'post_id' => $post->id,
            'tag_id' => $tag->id,
        ]);

        $this->assertCount(1, $tag->posts);

        $this->actingAs($user)->deleteJson("canvas/api/posts/{$post->id}")->assertSuccessful()->assertNoContent();

        $this->assertSoftDeleted('canvas_posts', [
            'id' => $post->id,
            'slug' => $post->slug,
        ]);

        $this->assertDatabaseMissing('canvas_posts_tags', [
            'post_id' => $post->id,
            'tag_id' => $tag->id,
        ]);

        $this->assertCount(0, $tag->refresh()->posts);
    }
}
