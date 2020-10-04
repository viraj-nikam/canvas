<?php

namespace Canvas\Tests\Services;

use Canvas\Models\Post;
use Canvas\Models\User;
use Canvas\Models\View;
use Canvas\Models\Visit;
use Canvas\Services\StatsAggregatorService;
use Canvas\Tests\TestCase;

/**
 * Class StatsAggregatorServiceTest.
 *
 * @covers \Canvas\Services\StatsAggregatorService
 */
class StatsAggregatorServiceTest extends TestCase
{
    /** @test */
    public function it_can_get_aggregate_stats_scoped_to_all()
    {
        $user = factory(User::class)->create();

        factory(Post::class, 3)->create([
            'user_id' => $user->id,
        ])->each(function ($post) {
            $post->views()->save(factory(View::class)->make());
        });

        factory(Post::class, 2)->create([
            'user_id' => 2,
        ])->each(function ($post) {
            $post->visits()->save(factory(Visit::class)->make());
        });

        $response = StatsAggregatorService::getByUserAndScope($user, 'all', 30);

        $this->assertArrayHasKey('totalViews', $response);
        $this->assertEquals(3, $response['totalViews']);

        $this->assertArrayHasKey('views', $response['traffic']);
        $this->assertJson($response['traffic']['views']);

        $this->assertArrayHasKey('totalVisits', $response);
        $this->assertEquals(2, $response['totalVisits']);

        $this->assertArrayHasKey('visits', $response['traffic']);
        $this->assertJson($response['traffic']['visits']);
    }

    /** @test */
    public function it_can_get_aggregate_stats_scoped_to_a_user()
    {
        $user = factory(User::class)->create();

        factory(Post::class, 3)->create([
            'user_id' => $user->id,
        ])->each(function ($post) {
            $post->views()->save(factory(View::class)->make());
        });

        factory(Post::class, 2)->create([
            'user_id' => 2,
        ])->each(function ($post) {
            $post->visits()->save(factory(Visit::class)->make());
        });

        $response = StatsAggregatorService::getByUserAndScope($user, 'user', 30);

        $this->assertArrayHasKey('totalViews', $response);
        $this->assertEquals(3, $response['totalViews']);

        $this->assertArrayHasKey('views', $response['traffic']);
        $this->assertJson($response['traffic']['views']);

        $this->assertArrayHasKey('totalVisits', $response);
        $this->assertEquals(0, $response['totalVisits']);

        $this->assertArrayHasKey('visits', $response['traffic']);
        $this->assertJson($response['traffic']['visits']);
    }

    /** @test */
    public function it_can_get_aggregate_stats_for_an_individual_post()
    {
        $post = factory(Post::class)->create();

        $response = StatsAggregatorService::getForPost($post, 30);

        $this->assertArrayHasKey('readTime', $response);

        $this->assertArrayHasKey('popularReadingTimes', $response);
        $this->assertIsArray($response['popularReadingTimes']);

        $this->assertArrayHasKey('topReferers', $response);
        $this->assertIsArray($response['topReferers']);

        $this->assertArrayHasKey('monthlyViews', $response);
        $this->assertIsInt($response['monthlyViews']);
        $this->assertEquals(0, $response['monthlyViews']);

        $this->assertArrayHasKey('monthlyVisits', $response);
        $this->assertIsInt($response['monthlyVisits']);
        $this->assertEquals(0, $response['monthlyVisits']);

        $this->assertArrayHasKey('totalViews', $response);
        $this->assertIsInt($response['totalViews']);
        $this->assertEquals(0, $response['totalViews']);

        $this->assertArrayHasKey('monthOverMonthViews', $response);
        $this->assertIsArray($response['monthOverMonthViews']);
        $this->assertArrayHasKey('direction', $response['monthOverMonthViews']);
        $this->assertIsString($response['monthOverMonthViews']['direction']);
        $this->assertArrayHasKey('percentage', $response['monthOverMonthViews']);
        $this->assertIsString($response['monthOverMonthViews']['percentage']);

        $this->assertArrayHasKey('monthOverMonthVisits', $response);
        $this->assertIsArray($response['monthOverMonthVisits']);
        $this->assertArrayHasKey('direction', $response['monthOverMonthVisits']);
        $this->assertIsString($response['monthOverMonthVisits']['direction']);
        $this->assertArrayHasKey('percentage', $response['monthOverMonthVisits']);
        $this->assertIsString($response['monthOverMonthVisits']['percentage']);

        $this->assertArrayHasKey('views', $response['traffic']);
        $this->assertJson($response['traffic']['views']);

        $this->assertArrayHasKey('visits', $response['traffic']);
        $this->assertJson($response['traffic']['visits']);
    }

    /** @test */
    public function it_can_get_find_the_month_to_month_difference_for_an_individual_post()
    {
        $post = factory(Post::class)->create();

        factory(View::class, 3)->create([
            'post_id' => $post->id,
            'created_at' => now()->subDays(32),
        ]);

        factory(Visit::class, 2)->create([
            'post_id' => $post->id,
            'created_at' => now()->subDays(32),
        ]);

        $response = StatsAggregatorService::getForPost($post, 30);

        $this->assertArrayHasKey('monthlyViews', $response);
        $this->assertIsInt($response['monthlyViews']);
        $this->assertEquals(0, $response['monthlyViews']);

        $this->assertArrayHasKey('monthlyVisits', $response);
        $this->assertIsInt($response['monthlyVisits']);
        $this->assertEquals(0, $response['monthlyVisits']);

        $this->assertArrayHasKey('totalViews', $response);
        $this->assertIsInt($response['totalViews']);
        $this->assertEquals(3, $response['totalViews']);

        $this->assertArrayHasKey('monthOverMonthViews', $response);
        $this->assertIsArray($response['monthOverMonthViews']);
        $this->assertArrayHasKey('direction', $response['monthOverMonthViews']);
        $this->assertIsString($response['monthOverMonthViews']['direction']);
        $this->assertSame('down', $response['monthOverMonthViews']['direction']);
        $this->assertArrayHasKey('percentage', $response['monthOverMonthViews']);
        $this->assertIsString($response['monthOverMonthViews']['percentage']);

        $this->assertArrayHasKey('monthOverMonthVisits', $response);
        $this->assertIsArray($response['monthOverMonthVisits']);
        $this->assertArrayHasKey('direction', $response['monthOverMonthVisits']);
        $this->assertIsString($response['monthOverMonthVisits']['direction']);
        $this->assertSame('down', $response['monthOverMonthVisits']['direction']);
        $this->assertArrayHasKey('percentage', $response['monthOverMonthVisits']);
        $this->assertIsString($response['monthOverMonthVisits']['percentage']);
    }
}
