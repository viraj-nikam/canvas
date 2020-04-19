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

    /**
     * Fresh resource defaults are returned.
     *
     * @return void
     */
    public function test_a_new_specified_resource()
    {
        $user = factory(config('canvas.user'))->create();

        $response = $this->actingAs($user)
                         ->getJson('canvas/api/settings')
                         ->assertSuccessful();

        $this->assertArrayHasKey('avatar', $response->decodeResponseJson());
        $this->assertArrayHasKey('dark_mode', $response->decodeResponseJson());
        $this->assertArrayHasKey('digest', $response->decodeResponseJson());
        $this->assertArrayHasKey('summary', $response->decodeResponseJson());
        $this->assertArrayHasKey('locale', $response->decodeResponseJson());
        $this->assertArrayHasKey('username', $response->decodeResponseJson());
    }

    /**
     * An existing resource is returned.
     *
     * @return void
     */
    public function test_an_existing_specified_resource()
    {
        $userMeta = factory(UserMeta::class)->create([
            'dark_mode' => 1,
            'digest' => 0,
            'locale' => 'en',
        ]);

        $response = $this->actingAs($userMeta->user)
                         ->getJson('canvas/api/settings')
                         ->assertSuccessful();

        $this->assertArrayHasKey('avatar', $response->decodeResponseJson());
        $this->assertArrayHasKey('dark_mode', $response->decodeResponseJson());
        $this->assertArrayHasKey('digest', $response->decodeResponseJson());
        $this->assertArrayHasKey('summary', $response->decodeResponseJson());
        $this->assertArrayHasKey('locale', $response->decodeResponseJson());
        $this->assertArrayHasKey('username', $response->decodeResponseJson());

        $this->assertEquals($userMeta->dark_mode, $response->decodeResponseJson('dark_mode'));
        $this->assertEquals($userMeta->digest, $response->decodeResponseJson('digest'));
        $this->assertEquals($userMeta->locale, $response->decodeResponseJson('locale'));
    }

    /**
     * A fresh resource can be stored.
     *
     * @return void
     */
    public function test_a_new_resource_can_be_stored()
    {
        $user = factory(config('canvas.user'))->create();

        $response = $this->actingAs($user)
                         ->postJson('canvas/api/settings', [
                             'user_id' => $user->id,
                         ])
                         ->assertSuccessful();

        $this->assertArrayHasKey('avatar', $response->decodeResponseJson());
        $this->assertArrayHasKey('dark_mode', $response->decodeResponseJson());
        $this->assertArrayHasKey('digest', $response->decodeResponseJson());
        $this->assertArrayHasKey('summary', $response->decodeResponseJson());
        $this->assertArrayHasKey('locale', $response->decodeResponseJson());
        $this->assertArrayHasKey('username', $response->decodeResponseJson());

        $this->assertEquals($user->id, $response->decodeResponseJson('user_id'));
    }

    /**
     * An existing resource can be updated.
     *
     * @return void
     */
    public function test_an_existing_resource_can_be_updated()
    {
        $userMeta = factory(UserMeta::class)->create();

        $response = $this->actingAs($userMeta->user)
                         ->postJson('canvas/api/settings', [
                             'user_id' => $userMeta->user_id,
                         ])
                         ->assertSuccessful();

        $this->assertArrayHasKey('avatar', $response->decodeResponseJson());
        $this->assertArrayHasKey('dark_mode', $response->decodeResponseJson());
        $this->assertArrayHasKey('digest', $response->decodeResponseJson());
        $this->assertArrayHasKey('summary', $response->decodeResponseJson());
        $this->assertArrayHasKey('locale', $response->decodeResponseJson());
        $this->assertArrayHasKey('username', $response->decodeResponseJson());

        $this->assertEquals($userMeta->user_id, $response->decodeResponseJson('user_id'));
    }

    /**
     * A username is unique to a user.
     *
     * @return void
     */
    public function test_usernames_must_be_unique()
    {
        $userMeta = factory(UserMeta::class)->create();

        factory(UserMeta::class)->create([
            'username' => 'an-existing-username',
        ]);

        $response = $this->actingAs($userMeta->user)
                         ->postJson('canvas/api/settings', [
                             'user_id' => $userMeta->user->id,
                             'username' => 'an-existing-username',
                         ])
                         ->assertStatus(422);

        $this->assertArrayHasKey('username', $response->decodeResponseJson('errors'));
    }
}
