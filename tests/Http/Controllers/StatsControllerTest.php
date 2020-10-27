<?php

namespace Canvas\Tests\Http\Controllers;

use Canvas\Models\Post;
use Canvas\Tests\TestCase;
use Exception;
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
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->registerAssertJsonExactFragmentMacro();
    }

    public function testUserPostsAreFetchedByDefault(): void
    {
        factory(Post::class, 3)->create([
            'user_id' => $this->admin->id,
        ]);

        factory(Post::class, 1)->create([
            'user_id' => $this->contributor->id,
        ]);

        $response = $this->actingAs($this->admin, 'canvas')->getJson('canvas/api/stats')->assertSuccessful();

        $this->assertArrayHasKey('totalViews', $response->original);
        $this->assertEquals(0, $response->original['totalViews']);

        $this->assertArrayHasKey('views', $response->original['traffic']);
        $this->assertJson($response->original['traffic']['views']);

        $this->assertArrayHasKey('totalVisits', $response->original);
        $this->assertEquals(0, $response->original['totalVisits']);

        $this->assertArrayHasKey('visits', $response->original['traffic']);
        $this->assertJson($response->original['traffic']['visits']);
    }

    public function testAllPostsCanBeFetchedWithAGivenQueryScope(): void
    {
        factory(Post::class, 3)->create([
            'user_id' => $this->editor->id,
        ]);

        factory(Post::class, 1)->create([
            'user_id' => $this->contributor->id,
        ]);

        $response = $this->actingAs($this->admin, 'canvas')->getJson('canvas/api/stats?scope=all')->assertSuccessful();

        $this->assertArrayHasKey('totalViews', $response->original);
        $this->assertEquals(0, $response->original['totalViews']);

        $this->assertArrayHasKey('views', $response->original['traffic']);
        $this->assertJson($response->original['traffic']['views']);

        $this->assertArrayHasKey('totalVisits', $response->original);
        $this->assertEquals(0, $response->original['totalVisits']);

        $this->assertArrayHasKey('visits', $response->original['traffic']);
        $this->assertJson($response->original['traffic']['visits']);
    }

    public function testAnAdminCanFetchAnyPostStats(): void
    {
        $post = factory(Post::class)->create([
            'user_id' => $this->contributor,
        ]);

        $response = $this->actingAs($this->admin, 'canvas')
                         ->getJson("canvas/api/stats/{$post->id}")
                         ->assertSuccessful()
                         ->assertJsonExactFragment($post->id, 'post.id');

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

    public function testAnEditorCanFetchAnyPostStats(): void
    {
        $post = factory(Post::class)->create([
            'user_id' => $this->contributor,
        ]);

        $response = $this->actingAs($this->editor, 'canvas')
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

    public function testAContributorCanFetchTheirOwnPostStats(): void
    {
        $post = factory(Post::class)->create([
            'user_id' => $this->contributor->id,
        ]);

        $response = $this->actingAs($this->contributor, 'canvas')
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

    public function testDraftPostsDoNotDisplayStats(): void
    {
        $post = factory(Post::class)->create([
            'published_at' => null,
        ]);

        $this->actingAs($this->admin, 'canvas')->getJson("canvas/api/stats/{$post->id}")->assertNotFound();
    }

    public function testScheduledPostsDoNotDisplayStats(): void
    {
        $post = factory(Post::class)->create([
            'published_at' => now()->addWeek(),
        ]);

        $this->actingAs($this->admin, 'canvas')->getJson("canvas/api/stats/{$post->id}")->assertNotFound();
    }

    public function testPostNotFound(): void
    {
        $this->actingAs($this->admin, 'canvas')->getJson('canvas/api/stats/not-a-post')->assertNotFound();
    }
}
