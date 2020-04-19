<?php

namespace Canvas\Tests\Controllers;

use Canvas\Http\Middleware\Session;
use Canvas\Tests\TestCase;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocaleControllerTest extends TestCase
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
    public function translations_can_be_fetched()
    {
        $user = factory(config('canvas.user'))->create();

        $response = $this->actingAs($user)->postJson('canvas/api/locale', [
            'locale', config('app.locale'),
        ])->assertSuccessful();

        $this->assertArrayHasKey('app', $response->decodeResponseJson());
    }
}
