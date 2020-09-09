<?php

namespace Canvas\Tests\Http\Controllers;

use Canvas\Models\Post;
use Canvas\Models\Tag;
use Canvas\Models\Topic;
use Canvas\Models\User;
use Canvas\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class SearchControllerTest.
 *
 * @covers \Canvas\Http\Controllers\SearchController
 */
class SearchControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->registerAssertJsonExactFragmentMacro();
    }

    /** @test */
    public function it_can_only_fetch_user_posts_for_contributors()
    {
        $user = factory(User::class)->create([
            'role' => User::CONTRIBUTOR,
        ]);

        factory(Post::class, 2)->create([
            'user_id' => $user->id,
        ]);

        factory(Post::class, 1)->create([
            'user_id' => 2,
            'published_at' => now()->addWeek(),
        ]);

        $response = $this->actingAs($user, 'canvas')
                         ->getJson('canvas/api/search/posts')
                         ->assertSuccessful();

        $this->assertCount(2, $response->original);
        $this->assertArrayHasKey('id', $response->original[0]);
        $this->assertArrayHasKey('title', $response->original[0]);
        $this->assertArrayHasKey('name', $response->original[0]);
        $this->assertArrayHasKey('type', $response->original[0]);
        $this->assertSame('Post', $response->original[0]['type']);
        $this->assertArrayHasKey('route', $response->original[0]);
        $this->assertSame('edit-post', $response->original[0]['route']);
    }

    /** @test */
    public function it_can_fetch_all_posts_for_editors()
    {
        $user = factory(User::class)->create([
            'role' => User::EDITOR,
        ]);

        factory(Post::class, 2)->create([
            'user_id' => $user->id,
        ]);

        factory(Post::class, 1)->create([
            'user_id' => 2,
            'published_at' => now()->addWeek(),
        ]);

        $response = $this->actingAs($user, 'canvas')
                         ->getJson('canvas/api/search/posts')
                         ->assertSuccessful();

        $this->assertCount(3, $response->original);
        $this->assertArrayHasKey('id', $response->original[0]);
        $this->assertArrayHasKey('title', $response->original[0]);
        $this->assertArrayHasKey('name', $response->original[0]);
        $this->assertArrayHasKey('type', $response->original[0]);
        $this->assertSame('Post', $response->original[0]['type']);
        $this->assertArrayHasKey('route', $response->original[0]);
        $this->assertSame('edit-post', $response->original[0]['route']);
    }

    /** @test */
    public function it_can_fetch_all_posts_for_admins()
    {
        $user = factory(User::class)->create([
            'role' => User::ADMIN,
        ]);

        factory(Post::class, 2)->create([
            'user_id' => $user->id,
        ]);

        factory(Post::class, 1)->create([
            'user_id' => 2,
            'published_at' => now()->addWeek(),
        ]);

        $response = $this->actingAs($user, 'canvas')
                         ->getJson('canvas/api/search/posts')
                         ->assertSuccessful();

        $this->assertCount(3, $response->original);
        $this->assertArrayHasKey('id', $response->original[0]);
        $this->assertArrayHasKey('title', $response->original[0]);
        $this->assertArrayHasKey('name', $response->original[0]);
        $this->assertArrayHasKey('type', $response->original[0]);
        $this->assertSame('Post', $response->original[0]['type']);
        $this->assertArrayHasKey('route', $response->original[0]);
        $this->assertSame('edit-post', $response->original[0]['route']);
    }

    /** @test */
    public function it_can_fetch_tags_for_an_admin_user()
    {
        $user = factory(User::class)->create([
            'role' => User::ADMIN,
        ]);

        factory(Tag::class, 2)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user, 'canvas')
                         ->getJson('canvas/api/search/tags')
                         ->assertSuccessful();

        $this->assertCount(2, $response->original);
        $this->assertArrayHasKey('id', $response->original[0]);
        $this->assertArrayHasKey('name', $response->original[0]);
        $this->assertArrayHasKey('type', $response->original[0]);
        $this->assertSame('Tag', $response->original[0]['type']);
        $this->assertArrayHasKey('route', $response->original[0]);
        $this->assertSame('edit-tag', $response->original[0]['route']);
    }

    /** @test */
    public function it_can_fetch_topics_for_an_admin_user()
    {
        $user = factory(User::class)->create([
            'role' => User::ADMIN,
        ]);

        factory(Topic::class, 2)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user, 'canvas')
                         ->getJson('canvas/api/search/topics')
                         ->assertSuccessful();

        $this->assertCount(2, $response->original);
        $this->assertArrayHasKey('id', $response->original[0]);
        $this->assertArrayHasKey('name', $response->original[0]);
        $this->assertArrayHasKey('type', $response->original[0]);
        $this->assertSame('Topic', $response->original[0]['type']);
        $this->assertArrayHasKey('route', $response->original[0]);
        $this->assertSame('edit-topic', $response->original[0]['route']);
    }

    /** @test */
    public function it_can_fetch_users_for_an_admin_user()
    {
        $user = factory(User::class)->create([
            'role' => User::ADMIN,
        ]);

        factory(User::class, 2)->create();

        $response = $this->actingAs($user, 'canvas')
                         ->getJson('canvas/api/search/users')
                         ->assertSuccessful();

        $this->assertCount(3, $response->original);
        $this->assertArrayHasKey('id', $response->original[0]);
        $this->assertArrayHasKey('name', $response->original[0]);
        $this->assertArrayHasKey('email', $response->original[0]);
        $this->assertArrayHasKey('type', $response->original[0]);
        $this->assertSame('User', $response->original[0]['type']);
        $this->assertArrayHasKey('route', $response->original[0]);
        $this->assertSame('edit-user', $response->original[0]['route']);
    }
}
