<?php

namespace Canvas\Tests\Http\Middleware;

use Canvas\Models\UserMeta;
use Canvas\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function restrictedRoutesProvider()
    {
        return [
            ['GET', 'canvas/api/tags'],
            ['GET', 'canvas/api/topics'],
            ['GET', 'canvas/api/users'],
            ['GET', 'canvas/api/tags/create'],
            ['GET', 'canvas/api/topics/create'],
            ['POST', 'canvas/api/tags/not-a-tag'],
            ['POST', 'canvas/api/topics/not-a-topic'],
            ['DELETE', 'canvas/api/tags/not-a-tag'],
            ['DELETE', 'canvas/api/topics/not-a-topic'],
        ];
    }

    /**
     * @test
     * @dataProvider restrictedRoutesProvider
     * @param $method
     * @param $endpoint
     */
    public function it_restricts_access_to_non_admins($method, $endpoint)
    {
        $meta = factory(UserMeta::class)->create();

        $this->actingAs($meta->user)->call($method, $endpoint)->assertForbidden();
    }
}
