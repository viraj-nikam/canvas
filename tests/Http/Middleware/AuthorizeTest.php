<?php

namespace Canvas\Tests\Http\Middleware;

use Canvas\Models\User;
use Canvas\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class AuthorizeTest.
 *
 * @covers \Canvas\Http\Middleware\Authorize
 */
class AuthorizeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array
     */
    public function protectedRoutesProvider(): array
    {
        return [
            ['POST', 'canvas/api/uploads'],
            ['DELETE', 'canvas/api/uploads'],
            ['GET', 'canvas/api/posts'],
            ['GET', 'canvas/api/posts/create'],
            ['GET', 'canvas/api/posts/existing-post'],
            ['POST', 'canvas/api/posts/a-new-post'],
            ['DELETE', 'canvas/api/posts/existing-post'],
            ['GET', 'canvas/api/stats'],
            ['GET', 'canvas/api/stats/existing-post'],
            ['GET', 'canvas/api/tags'],
            ['GET', 'canvas/api/tags/create'],
            ['GET', 'canvas/api/tags/existing-tag'],
            ['POST', 'canvas/api/tags/a-new-tag'],
            ['DELETE', 'canvas/api/tags/existing-tag'],
            ['GET', 'canvas/api/topics'],
            ['GET', 'canvas/api/topics/create'],
            ['GET', 'canvas/api/topics/existing-topic'],
            ['POST', 'canvas/api/topics/a-new-topic'],
            ['DELETE', 'canvas/api/topics/existing-topic'],
            ['GET', 'canvas/api/users'],
            ['GET', 'canvas/api/users/create'],
            ['GET', 'canvas/api/users/1'],
            ['POST', 'canvas/api/users/1'],
            ['DELETE', 'canvas/api/users/1'],
            ['GET', 'canvas/api/search/posts'],
            ['GET', 'canvas/api/search/tags'],
            ['GET', 'canvas/api/search/topics'],
            ['GET', 'canvas/api/search/users'],
        ];
    }

    /**
     * @test
     * @dataProvider protectedRoutesProvider
     * @param $method
     * @param $endpoint
     */
    public function it_restricts_access_for_users_without_a_meta_record($method, $endpoint)
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)->call($method, $endpoint)->assertForbidden();
    }
}
