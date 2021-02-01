<?php

namespace Canvas\Tests\Http\Middleware;

use Canvas\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class AdminTest.
 *
 * @covers \Canvas\Http\Middleware\AdminMiddleware
 */
class AdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array
     */
    public function protectedRoutesProvider(): array
    {
        return [
            // Tag routes...
            ['GET', 'canvas/api/tags'],
            ['GET', 'canvas/api/tags/create'],
            ['GET', 'canvas/api/tags/{id}/posts'],

            // Topic routes...
            ['GET', 'canvas/api/topics'],
            ['GET', 'canvas/api/topics/create'],
            ['GET', 'canvas/api/topics/{id}/posts'],

            // User routes...
            ['GET', 'canvas/api/users'],
            ['GET', 'canvas/api/users/create'],

            // Search routes...
            ['GET', 'canvas/api/search/tags'],
            ['GET', 'canvas/api/search/topics'],
            ['GET', 'canvas/api/search/users'],
        ];
    }

    /**
     * @dataProvider protectedRoutesProvider
     * @param $method
     * @param $endpoint
     */
    public function testContributorAccessIsRestricted($method, $endpoint)
    {
        $this->actingAs($this->contributor, 'canvas')
             ->call($method, $endpoint)
             ->assertForbidden();
    }

    /**
     * @dataProvider protectedRoutesProvider
     * @param $method
     * @param $endpoint
     */
    public function testEditorAccessIsRestricted($method, $endpoint)
    {
        $this->actingAs($this->editor, 'canvas')
             ->call($method, $endpoint)
             ->assertForbidden();
    }

    /**
     * @dataProvider protectedRoutesProvider
     * @param $method
     * @param $endpoint
     */
    public function testAdminAccessIsGranted($method, $endpoint)
    {
        $this->actingAs($this->admin, 'canvas')
             ->call($method, $endpoint)
             ->assertSuccessful();
    }
}
