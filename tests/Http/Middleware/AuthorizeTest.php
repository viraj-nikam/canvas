<?php

namespace Canvas\Tests\Http\Middleware;

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
            // Upload routes...
            ['POST', 'canvas/api/uploads'],
            ['DELETE', 'canvas/api/uploads'],

            // Post routes...
            ['GET', 'canvas/api/posts'],
            ['GET', 'canvas/api/posts/create'],
            ['GET', 'canvas/api/posts/existing-post'],
            ['POST', 'canvas/api/posts/a-new-post'],
            ['DELETE', 'canvas/api/posts/existing-post'],

            // Stat routes...
            ['GET', 'canvas/api/stats'],
            ['GET', 'canvas/api/stats/existing-post'],

            // Tag routes...
            ['GET', 'canvas/api/tags'],
            ['GET', 'canvas/api/tags/create'],
            ['GET', 'canvas/api/tags/existing-tag'],
            ['POST', 'canvas/api/tags/a-new-tag'],
            ['DELETE', 'canvas/api/tags/existing-tag'],

            // Topic routes...
            ['GET', 'canvas/api/topics'],
            ['GET', 'canvas/api/topics/create'],
            ['GET', 'canvas/api/topics/existing-topic'],
            ['POST', 'canvas/api/topics/a-new-topic'],
            ['DELETE', 'canvas/api/topics/existing-topic'],

            // User routes...
            ['GET', 'canvas/api/users'],
            ['GET', 'canvas/api/users/create'],
            ['GET', 'canvas/api/users/1'],
            ['POST', 'canvas/api/users/1'],
            ['DELETE', 'canvas/api/users/1'],

            // Search routes...
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
    public function it_redirects_unauthenticated_users_to_login($method, $endpoint)
    {
        $this->assertGuest()->call($method, $endpoint)->assertRedirect(route('canvas.login'));
    }
}
