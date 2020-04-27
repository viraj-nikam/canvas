<?php

namespace Canvas\Tests;

use Canvas\Http\Middleware\Session;
use Canvas\Post;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware([Authorize::class, Session::class, VerifyCsrfToken::class]);
    }

    /** @test */
    public function human_friendly_read_time()
    {
        $post = factory(Post::class)->create();

        $minutes = ceil(str_word_count($post->body) / 250);

        $this->assertEquals($post->readTime, sprintf('%d %s %s', $minutes, Str::plural(__('canvas::app.min'), $minutes), __('canvas::app.read')));
    }

    /** @test */
    public function posts_can_share_the_same_slug_with_unique_users()
    {
        $data = [
            'slug' => 'a-new-post',
        ];

        $post_1 = factory(Post::class)->create();
        $response = $this->actingAs($post_1->user)->postJson("/canvas/api/posts/{$post_1->id}", $data);

        $this->assertDatabaseHas('canvas_posts', [
            'id' => $response->decodeResponseJson('id'),
            'slug' => $response->decodeResponseJson('slug'),
            'user_id' => $response->decodeResponseJson('user_id'),
        ]);

        $post_2 = factory(Post::class)->create();
        $response = $this->actingAs($post_2->user)->postJson("/canvas/api/posts/{$post_2->id}", $data);

        $this->assertDatabaseHas('canvas_posts', [
            'id' => $response->decodeResponseJson('id'),
            'slug' => $response->decodeResponseJson('slug'),
            'user_id' => $response->decodeResponseJson('user_id'),
        ]);
    }
}
