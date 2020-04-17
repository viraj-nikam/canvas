<?php

namespace Canvas\Tests\Controllers;

use Canvas\Http\Middleware\Session;
use Canvas\Tests\TestCase;
use Canvas\UserMeta;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SettingsControllerTest extends TestCase
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
    public function display_a_listing_of_the_resource()
    {
        $userMeta = factory(UserMeta::class)->create([
            'dark_mode' => 1,
            'digest' => 0,
            'locale' => 'en',
        ]);

        $response = $this->actingAs($userMeta->user)
                         ->get('canvas/api/settings')
                         ->assertSuccessful();

        $this->assertArrayHasKey('avatar', $response->decodeResponseJson());
        $this->assertArrayHasKey('dark_mode', $response->decodeResponseJson());
        $this->assertArrayHasKey('digest', $response->decodeResponseJson());
        $this->assertArrayHasKey('summary', $response->decodeResponseJson());
        $this->assertArrayHasKey('locale', $response->decodeResponseJson());
        $this->assertArrayHasKey('username', $response->decodeResponseJson());

        $this->assertSame($userMeta->dark_mode, $response->decodeResponseJson('dark_mode'));
        $this->assertSame($userMeta->digest, $response->decodeResponseJson('digest'));
        $this->assertSame($userMeta->locale, $response->decodeResponseJson('locale'));
    }
}
