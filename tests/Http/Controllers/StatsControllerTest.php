<?php

namespace Canvas\Tests\Http\Controllers;

use Canvas\Http\Middleware\Session;
use Canvas\Post;
use Canvas\Tests\TestCase;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatsControllerTest extends TestCase
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
    public function stats_can_be_listed()
    {
        $user = factory(config('canvas.user'))->create();

        $response = $this->actingAs($user)->getJson('canvas/api/stats')->assertSuccessful();

        $this->assertArrayHasKey('view_count', $response->decodeResponseJson());
        $this->assertEquals(0, $response->decodeResponseJson('view_count'));

        $this->assertArrayHasKey('view_trend', $response->decodeResponseJson());
        $this->assertJson($response->decodeResponseJson('view_trend'));

        $this->assertArrayHasKey('visit_count', $response->decodeResponseJson());
        $this->assertEquals(0, $response->decodeResponseJson('visit_count'));

        $this->assertArrayHasKey('visit_trend', $response->decodeResponseJson());
        $this->assertJson($response->decodeResponseJson('visit_trend'));
    }

    /** @test */
    public function stats_can_be_fetched()
    {
        $post = factory(Post::class)->create();

        $this->actingAs($post->user)->getJson('canvas/api/stats/not-a-post')->assertNotFound();

        $response = $this->actingAs($post->user)
                         ->getJson("canvas/api/stats/{$post->id}")
                         ->assertSuccessful()
                         ->assertJsonExactFragment($post->id, 'post.id');

        $this->assertArrayHasKey('read_time', $response);

        $this->assertArrayHasKey('popular_reading_times', $response);
        $this->assertIsArray($response->decodeResponseJson('popular_reading_times'));

        $this->assertArrayHasKey('traffic', $response);
        $this->assertIsArray($response->decodeResponseJson('traffic'));

        $this->assertArrayHasKey('view_count', $response);
        $this->assertArrayHasKey('view_trend', $response);
        $this->assertArrayHasKey('view_month_over_month', $response);
        $this->assertArrayHasKey('view_count_lifetime', $response);
        $this->assertIsArray($response->decodeResponseJson('view_month_over_month'));
        $this->assertEquals(0, $response->decodeResponseJson('view_count'));
        $this->assertJson($response->decodeResponseJson('view_trend'));

        $this->assertArrayHasKey('visit_count', $response);
        $this->assertArrayHasKey('visit_trend', $response);
        $this->assertArrayHasKey('visit_month_over_month', $response);
        $this->assertIsArray($response->decodeResponseJson('visit_month_over_month'));
        $this->assertEquals(0, $response->decodeResponseJson('visit_count'));
        $this->assertJson($response->decodeResponseJson('visit_trend'));
    }
}
