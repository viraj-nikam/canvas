<?php

namespace Canvas\Tests\Http\Controllers;

use Canvas\Http\Middleware\Session;
use Canvas\Tests\TestCase;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConfigControllerTest extends TestCase
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
    public function basic_config_information_can_be_fetched()
    {
        $user = factory(config('canvas.user'))->create();

        $response = $this->actingAs($user)->getJson('canvas/api/config')->assertSuccessful();

        $this->assertArrayHasKey('codes', $response->decodeResponseJson('locale'));
        $this->assertArrayHasKey('current', $response->decodeResponseJson('locale'));
        $this->assertArrayHasKey('translations', $response->decodeResponseJson('locale'));
        $this->assertArrayHasKey('maxUpload', $response->decodeResponseJson());
        $this->assertArrayHasKey('path', $response->decodeResponseJson());
        $this->assertArrayHasKey('timezone', $response->decodeResponseJson());
        $this->assertArrayHasKey('unsplash', $response->decodeResponseJson());
    }
}
