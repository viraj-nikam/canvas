<?php

namespace Canvas\Tests\Http\Controllers;

use Canvas\Models\Post;
use Canvas\Models\User;
use Canvas\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class StatsControllerTest.
 *
 * @covers \Canvas\Http\Controllers\StatsController
 */
class StatsControllerTest extends TestCase
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
    public function it_can_fetch_stats_for_user_posts()
    {
        $user = factory(User::class)->create();

        factory(Post::class, 3)->create([
            'user_id' => $user->id,
        ]);

        factory(Post::class, 1)->create([
            'user_id' => 2,
        ]);

        $response = $this->actingAs($user, 'canvas')->getJson('canvas/api/stats')->assertSuccessful();

        $this->assertArrayHasKey('posts', $response->original);
        $this->assertCount(3, $response->original['posts']);

        $this->assertArrayHasKey('totalViews', $response->original);
        $this->assertEquals(0, $response->original['totalViews']);

        $this->assertArrayHasKey('views', $response->original['traffic']);
        $this->assertJson($response->original['traffic']['views']);

        $this->assertArrayHasKey('totalVisits', $response->original);
        $this->assertEquals(0, $response->original['totalVisits']);

        $this->assertArrayHasKey('visits', $response->original['traffic']);
        $this->assertJson($response->original['traffic']['visits']);
    }

    /** @test */
    public function it_can_fetch_stats_for_all_posts()
    {
        $user = factory(User::class)->create();

        factory(Post::class, 3)->create([
            'user_id' => $user->id,
        ]);

        factory(Post::class, 1)->create([
            'user_id' => 2,
        ]);

        $response = $this->actingAs($user, 'canvas')->getJson('canvas/api/stats?scope=all')->assertSuccessful();

        $this->assertArrayHasKey('posts', $response->original);
        $this->assertCount(4, $response->original['posts']);

        $this->assertArrayHasKey('totalViews', $response->original);
        $this->assertEquals(0, $response->original['totalViews']);

        $this->assertArrayHasKey('views', $response->original['traffic']);
        $this->assertJson($response->original['traffic']['views']);

        $this->assertArrayHasKey('totalVisits', $response->original);
        $this->assertEquals(0, $response->original['totalVisits']);

        $this->assertArrayHasKey('visits', $response->original['traffic']);
        $this->assertJson($response->original['traffic']['visits']);
    }

    /** @test */
    public function it_can_show_stats_for_another_users_published_post_as_an_admin()
    {
        $admin = factory(User::class)->create([
            'role' => User::ADMIN,
        ]);

        $post = factory(Post::class)->create([
            'user_id' => 123,
        ]);

        $response = $this->actingAs($admin, 'canvas')
                         ->getJson("canvas/api/stats/{$post->id}")
                         ->assertSuccessful()
                         ->assertJsonExactFragment($post->id, 'post.id');

        $this->assertArrayHasKey('post', $response->original);

        $this->assertArrayHasKey('readTime', $response->original);

        $this->assertArrayHasKey('popularReadingTimes', $response->original);
        $this->assertIsArray($response->original['popularReadingTimes']);

        $this->assertArrayHasKey('topReferers', $response);
        $this->assertIsArray($response->original['topReferers']);

        $this->assertArrayHasKey('monthlyViews', $response->original);
        $this->assertIsInt($response->original['monthlyViews']);
        $this->assertEquals(0, $response->original['monthlyViews']);

        $this->assertArrayHasKey('monthlyVisits', $response->original);
        $this->assertIsInt($response->original['monthlyVisits']);
        $this->assertEquals(0, $response->original['monthlyVisits']);

        $this->assertArrayHasKey('totalViews', $response->original);
        $this->assertIsInt($response->original['totalViews']);
        $this->assertEquals(0, $response->original['totalViews']);

        $this->assertArrayHasKey('monthOverMonthViews', $response->original);
        $this->assertIsArray($response->original['monthOverMonthViews']);
        $this->assertArrayHasKey('direction', $response->original['monthOverMonthViews']);
        $this->assertIsString($response->original['monthOverMonthViews']['direction']);
        $this->assertArrayHasKey('percentage', $response->original['monthOverMonthViews']);
        $this->assertIsString($response->original['monthOverMonthViews']['percentage']);

        $this->assertArrayHasKey('monthOverMonthVisits', $response->original);
        $this->assertIsArray($response->original['monthOverMonthVisits']);
        $this->assertArrayHasKey('direction', $response->original['monthOverMonthVisits']);
        $this->assertIsString($response->original['monthOverMonthVisits']['direction']);
        $this->assertArrayHasKey('percentage', $response->original['monthOverMonthVisits']);
        $this->assertIsString($response->original['monthOverMonthVisits']['percentage']);

        $this->assertArrayHasKey('views', $response->original['traffic']);
        $this->assertJson($response->original['traffic']['views']);

        $this->assertArrayHasKey('visits', $response->original['traffic']);
        $this->assertJson($response->original['traffic']['visits']);
    }

    /** @test */
    public function it_can_show_stats_for_another_users_published_post_as_an_editor()
    {
        $editor = factory(User::class)->create([
            'role' => User::EDITOR,
        ]);

        $post = factory(Post::class)->create([
            'user_id' => 123,
        ]);

        $response = $this->actingAs($editor, 'canvas')
                         ->getJson("canvas/api/stats/{$post->id}")
                         ->assertSuccessful()
                         ->assertJsonExactFragment($post->id, 'post.id');

        $this->assertArrayHasKey('post', $response->original);

        $this->assertArrayHasKey('readTime', $response->original);

        $this->assertArrayHasKey('popularReadingTimes', $response->original);
        $this->assertIsArray($response->original['popularReadingTimes']);

        $this->assertArrayHasKey('topReferers', $response);
        $this->assertIsArray($response->original['topReferers']);

        $this->assertArrayHasKey('monthlyViews', $response->original);
        $this->assertIsInt($response->original['monthlyViews']);
        $this->assertEquals(0, $response->original['monthlyViews']);

        $this->assertArrayHasKey('monthlyVisits', $response->original);
        $this->assertIsInt($response->original['monthlyVisits']);
        $this->assertEquals(0, $response->original['monthlyVisits']);

        $this->assertArrayHasKey('totalViews', $response->original);
        $this->assertIsInt($response->original['totalViews']);
        $this->assertEquals(0, $response->original['totalViews']);

        $this->assertArrayHasKey('monthOverMonthViews', $response->original);
        $this->assertIsArray($response->original['monthOverMonthViews']);
        $this->assertArrayHasKey('direction', $response->original['monthOverMonthViews']);
        $this->assertIsString($response->original['monthOverMonthViews']['direction']);
        $this->assertArrayHasKey('percentage', $response->original['monthOverMonthViews']);
        $this->assertIsString($response->original['monthOverMonthViews']['percentage']);

        $this->assertArrayHasKey('monthOverMonthVisits', $response->original);
        $this->assertIsArray($response->original['monthOverMonthVisits']);
        $this->assertArrayHasKey('direction', $response->original['monthOverMonthVisits']);
        $this->assertIsString($response->original['monthOverMonthVisits']['direction']);
        $this->assertArrayHasKey('percentage', $response->original['monthOverMonthVisits']);
        $this->assertIsString($response->original['monthOverMonthVisits']['percentage']);

        $this->assertArrayHasKey('views', $response->original['traffic']);
        $this->assertJson($response->original['traffic']['views']);

        $this->assertArrayHasKey('visits', $response->original['traffic']);
        $this->assertJson($response->original['traffic']['visits']);
    }

    /** @test */
    public function it_can_show_stats_for_a_users_published_post_as_a_contributor()
    {
        $contributor = factory(User::class)->create([
            'role' => User::CONTRIBUTOR,
        ]);

        $post = factory(Post::class)->create([
            'user_id' => $contributor->id,
        ]);

        $response = $this->actingAs($contributor, 'canvas')
                         ->getJson("canvas/api/stats/{$post->id}")
                         ->assertSuccessful()
                         ->assertJsonExactFragment($post->id, 'post.id');

        $this->assertArrayHasKey('post', $response->original);

        $this->assertArrayHasKey('readTime', $response->original);

        $this->assertArrayHasKey('popularReadingTimes', $response->original);
        $this->assertIsArray($response->original['popularReadingTimes']);

        $this->assertArrayHasKey('topReferers', $response);
        $this->assertIsArray($response->original['topReferers']);

        $this->assertArrayHasKey('monthlyViews', $response->original);
        $this->assertIsInt($response->original['monthlyViews']);
        $this->assertEquals(0, $response->original['monthlyViews']);

        $this->assertArrayHasKey('monthlyVisits', $response->original);
        $this->assertIsInt($response->original['monthlyVisits']);
        $this->assertEquals(0, $response->original['monthlyVisits']);

        $this->assertArrayHasKey('totalViews', $response->original);
        $this->assertIsInt($response->original['totalViews']);
        $this->assertEquals(0, $response->original['totalViews']);

        $this->assertArrayHasKey('monthOverMonthViews', $response->original);
        $this->assertIsArray($response->original['monthOverMonthViews']);
        $this->assertArrayHasKey('direction', $response->original['monthOverMonthViews']);
        $this->assertIsString($response->original['monthOverMonthViews']['direction']);
        $this->assertArrayHasKey('percentage', $response->original['monthOverMonthViews']);
        $this->assertIsString($response->original['monthOverMonthViews']['percentage']);

        $this->assertArrayHasKey('monthOverMonthVisits', $response->original);
        $this->assertIsArray($response->original['monthOverMonthVisits']);
        $this->assertArrayHasKey('direction', $response->original['monthOverMonthVisits']);
        $this->assertIsString($response->original['monthOverMonthVisits']['direction']);
        $this->assertArrayHasKey('percentage', $response->original['monthOverMonthVisits']);
        $this->assertIsString($response->original['monthOverMonthVisits']['percentage']);

        $this->assertArrayHasKey('views', $response->original['traffic']);
        $this->assertJson($response->original['traffic']['views']);

        $this->assertArrayHasKey('visits', $response->original['traffic']);
        $this->assertJson($response->original['traffic']['visits']);
    }

    /** @test */
    public function it_returns_404_if_post_is_not_published()
    {
        $post = factory(Post::class)->create([
            'published_at' => now()->addWeek(),
        ]);

        $this->actingAs($post->user, 'canvas')->getJson("canvas/api/stats/{$post->id}")->assertNotFound();
    }

    /** @test */
    public function it_returns_404_if_no_post_is_found()
    {
        $this->actingAs(factory(User::class)->create(), 'canvas')->getJson('canvas/api/stats/not-a-post')->assertNotFound();
    }
}
