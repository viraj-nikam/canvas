<?php

namespace Canvas\Tests\Http\Controllers;

use Canvas\Http\Middleware\Session;
use Canvas\Models\UserMeta;
use Canvas\Tests\TestCase;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
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
    public function it_can_fetch_new_user_meta_data()
    {
        $user = factory(config('canvas.user'))->create();

        $response = $this->actingAs($user)->getJson("canvas/api/users/{$user->id}")->assertSuccessful();

        $this->assertArrayHasKey('avatar', $response->decodeResponseJson());
        $this->assertArrayHasKey('darkMode', $response->decodeResponseJson());
        $this->assertArrayHasKey('digest', $response->decodeResponseJson());
        $this->assertArrayHasKey('summary', $response->decodeResponseJson());
        $this->assertArrayHasKey('locale', $response->decodeResponseJson());
        $this->assertArrayHasKey('username', $response->decodeResponseJson());
    }

    /** @test */
    public function it_can_fetch_existing_user_meta_data()
    {
        $meta = factory(UserMeta::class)->create([
            'dark_mode' => 1,
            'digest' => 0,
            'locale' => 'en',
        ]);

        $response = $this->actingAs($meta->user)->getJson("canvas/api/users/{$meta->user_id}")->assertSuccessful();

        $this->assertArrayHasKey('avatar', $response->decodeResponseJson());
        $this->assertArrayHasKey('darkMode', $response->decodeResponseJson());
        $this->assertArrayHasKey('digest', $response->decodeResponseJson());
        $this->assertArrayHasKey('summary', $response->decodeResponseJson());
        $this->assertArrayHasKey('locale', $response->decodeResponseJson());
        $this->assertArrayHasKey('username', $response->decodeResponseJson());

        $this->assertEquals($meta->dark_mode, $response->decodeResponseJson('darkMode'));
        $this->assertEquals($meta->digest, $response->decodeResponseJson('digest'));
        $this->assertEquals($meta->locale, $response->decodeResponseJson('locale'));
    }

    /** @test */
    public function it_can_store_user_meta_data()
    {
        $user = factory(config('canvas.user'))->create();

        $response = $this->actingAs($user)->postJson("canvas/api/users/{$user->id}", [
            'user_id' => $user->id,
        ])->assertSuccessful();

        $this->assertArrayHasKey('avatar', $response->decodeResponseJson());
        $this->assertArrayHasKey('dark_mode', $response->decodeResponseJson());
        $this->assertArrayHasKey('digest', $response->decodeResponseJson());
        $this->assertArrayHasKey('summary', $response->decodeResponseJson());
        $this->assertArrayHasKey('locale', $response->decodeResponseJson());
        $this->assertArrayHasKey('username', $response->decodeResponseJson());

        $this->assertEquals($user->id, $response->decodeResponseJson('user_id'));
    }

    /** @test */
    public function it_can_update_user_meta_data()
    {
        $user = factory(config('canvas.user'))->create();

        $response = $this->actingAs($user)->postJson("canvas/api/users/{$user->id}", [
            'user_id' => $user->id,
        ])->assertSuccessful();

        $this->assertArrayHasKey('avatar', $response->decodeResponseJson());
        $this->assertArrayHasKey('dark_mode', $response->decodeResponseJson());
        $this->assertArrayHasKey('digest', $response->decodeResponseJson());
        $this->assertArrayHasKey('summary', $response->decodeResponseJson());
        $this->assertArrayHasKey('locale', $response->decodeResponseJson());
        $this->assertArrayHasKey('username', $response->decodeResponseJson());

        $this->assertEquals($user->id, $response->decodeResponseJson('user_id'));
    }

    /** @test */
    public function it_verifies_usernames_are_unique_to_a_user()
    {
        $meta = factory(UserMeta::class)->create();

        factory(UserMeta::class)->create([
            'username' => 'an-existing-username',
        ]);

        $response = $this->actingAs($meta->user)->postJson("canvas/api/users/{$meta->user_id}", [
            'user_id' => $meta->user->id,
            'username' => 'an-existing-username',
        ])->assertStatus(422);

        $this->assertArrayHasKey('username', $response->decodeResponseJson('errors'));
    }
}
