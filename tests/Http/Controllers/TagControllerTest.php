<?php

namespace Canvas\Tests\Controllers;

use Canvas\Http\Middleware\Session;
use Canvas\Tag;
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
        $user_1 = factory(config('canvas.user'))->create();
        $user_2 = factory(config('canvas.user'))->create();

        $tag = factory(Tag::class)->create([
            'user_id' => $user_1->id,
            'name' => 'A new tag',
            'slug' => 'a-new-tag',
        ]);

        $this->actingAs($user_1)
             ->getJson('canvas/api/tags')
             ->assertSuccessful()
             ->assertJsonExactFragment($tag->id, 'data.0.id')
             ->assertJsonExactFragment($tag->name, 'data.0.name')
             ->assertJsonExactFragment($user_1->id, 'data.0.user_id')
             ->assertJsonExactFragment($tag->slug, 'data.0.slug')
             ->assertJsonExactFragment($tag->posts->count(), 'data.0.posts_count')
             ->assertJsonExactFragment(1, 'total');

        $this->actingAs($user_2)
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

        // Tag not found...
        $this->actingAs($user)->getJson('canvas/api/tags/not-a-tag')->assertNotFound();
    }

    /** @test */
    public function only_tag_owners_can_access_tags()
    {
        $user_1 = factory(config('canvas.user'))->create();
        $user_2 = factory(config('canvas.user'))->create();

        $tag = factory(Tag::class)->create([
            'user_id' => $user_1->id,
            'name' => 'A tag for user 1',
            'slug' => 'a-tag-for-user-1',
        ]);

        $this->actingAs($user_2)->getJson("canvas/api/tags/{$tag->id}")->assertNotFound();
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
        $tag = factory(Tag::class)->create();

        $data = [
            'name' => 'A new tag',
            'slug' => 'a-new-tag',
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
        $user_1 = factory(config('canvas.user'))->create();
        $user_2 = factory(config('canvas.user'))->create();

        $tag = factory(Tag::class)->create([
            'user_id' => $user_1->id,
            'name' => 'A new tag',
            'slug' => 'a-new-tag',
        ]);

        $this->actingAs($user_2)
             ->deleteJson("canvas/api/tags/{$tag->id}")
             ->assertNotFound();

        $this->actingAs($user_1)
             ->deleteJson('canvas/api/tags/not-a-tag')
             ->assertNotFound();

        $this->actingAs($user_1)
             ->deleteJson("canvas/api/tags/{$tag->id}")
             ->assertSuccessful()
             ->assertNoContent();

        $this->assertSoftDeleted('canvas_tags', [
            'id' => $tag->id,
            'slug' => $tag->slug,
        ]);
    }
}
