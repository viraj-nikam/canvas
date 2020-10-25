<?php

namespace Canvas\Tests\Http\Controllers;

use Canvas\Models\Post;
use Canvas\Models\Tag;
use Canvas\Models\Topic;
use Canvas\Tests\TestCase;
use Exception;
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
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->registerAssertJsonExactFragmentMacro();
    }

    public function testAContributorCanOnlySearchTheirOwnPosts(): void
    {
        factory(Post::class, 2)->create([
            'user_id' => $this->contributor->id,
        ]);

        factory(Post::class, 1)->create([
            'user_id' => $this->admin->id,
            'published_at' => now()->addWeek(),
        ]);

        $response = $this->actingAs($this->contributor, 'canvas')
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

    public function testAnEditorCanSearchAllPosts(): void
    {
        factory(Post::class, 2)->create([
            'user_id' => $this->editor->id,
        ]);

        factory(Post::class, 1)->create([
            'user_id' => $this->contributor->id,
            'published_at' => now()->addWeek(),
        ]);

        $response = $this->actingAs($this->editor, 'canvas')
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

    public function testAnAdminCanSearchAllPosts(): void
    {
        factory(Post::class, 2)->create([
            'user_id' => $this->admin->id,
        ]);

        factory(Post::class, 1)->create([
            'user_id' => $this->editor->id,
            'published_at' => now()->addWeek(),
        ]);

        $response = $this->actingAs($this->admin, 'canvas')
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

    public function testAnAdminCanSearchAllTags(): void
    {
        factory(Tag::class, 2)->create([
            'user_id' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin, 'canvas')
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

    public function testAnAdminCanSearchAllTopics(): void
    {
        factory(Topic::class, 2)->create([
            'user_id' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin, 'canvas')
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

    public function testAnAdminCanSearchAllUsers(): void
    {
        $response = $this->actingAs($this->admin, 'canvas')
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
