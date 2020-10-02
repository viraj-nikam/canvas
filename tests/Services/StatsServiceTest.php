<?php

namespace Canvas\Tests\Services;

use Canvas\Models\Post;
use Canvas\Models\User;
use Canvas\Services\StatsService;
use Canvas\Tests\TestCase;

/**
 * Class StatsServiceTest.
 *
 * @covers \Canvas\Services\StatsService
 */
class StatsServiceTest extends TestCase
{
    /** @test */
    public function it_can_gather_aggregate_stats()
    {
        $user = factory(User::class)->create();

        factory(Post::class, 3)->create([
            'user_id' => $user->id,
        ]);

        factory(Post::class, 1)->create([
            'user_id' => 2,
        ]);

        $response = StatsService::aggregate($user, 'published', 30);

        $this->assertArrayHasKey('totalViews', $response);
        $this->assertEquals(0, $response['totalViews']);

        $this->assertArrayHasKey('views', $response['traffic']);
        $this->assertJson($response['traffic']['views']);

        $this->assertArrayHasKey('totalVisits', $response);
        $this->assertEquals(0, $response['totalVisits']);

        $this->assertArrayHasKey('visits', $response['traffic']);
        $this->assertJson($response['traffic']['visits']);
    }

    /** @test */
    public function it_can_gather_individual_stats()
    {
        $post = factory(Post::class)->create();

        $response = StatsService::individual($post, 30);

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
}
