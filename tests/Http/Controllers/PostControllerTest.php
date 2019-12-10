<?php

namespace Canvas\Tests\Controllers;

use Canvas\Http\Controllers\PostController;
use Canvas\Tests\TestCase;
use Ramsey\Uuid\Uuid;

class PostControllerTest extends TestCase
{
    /**
     * The controller instance.
     *
     * @var PostController
     */
    protected $instance;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->instance = new PostController();
    }

    /** @test */
    public function allow_posts_to_share_the_same_slug_with_unique_users()
    {
        $user_1 = factory(\Illuminate\Foundation\Auth\User::class)->create();
        $post_1 = $this->actingAs($user_1)->withoutMiddleware()->post('/canvas/api/posts/create', [
            'id'    => Uuid::uuid4(),
            'slug'  => 'a-new-hope',
            'topic' => [],
            'tags'  => [],
        ]);

        $user_2 = factory(\Illuminate\Foundation\Auth\User::class)->create();
        $post_2 = $this->actingAs($user_2)->withoutMiddleware()->post('/canvas/api/posts/create', [
            'id'    => Uuid::uuid4(),
            'slug'  => 'a-new-hope',
            'topic' => [],
            'tags'  => [],
        ]);

        $this->assertDatabaseHas('canvas_posts', [
            'id'      => $post_1->decodeResponseJson()['id'],
            'slug'    => $post_1->decodeResponseJson()['slug'],
            'user_id' => $post_1->decodeResponseJson()['user_id'],
        ]);

        $this->assertDatabaseHas('canvas_posts', [
            'id'      => $post_2->decodeResponseJson()['id'],
            'slug'    => $post_2->decodeResponseJson()['slug'],
            'user_id' => $post_2->decodeResponseJson()['user_id'],
        ]);
    }
}
