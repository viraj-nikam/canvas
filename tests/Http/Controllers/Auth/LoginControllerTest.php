<?php

namespace Canvas\Tests\Http\Controllers\Auth;

use Canvas\Models\User;
use Canvas\Tests\TestCase;
use Illuminate\Support\Facades\Hash;

/**
 * Class LoginControllerTest.
 *
 * @covers \Canvas\Http\Controllers\Auth\LoginController
 */
class LoginControllerTest extends TestCase
{
    /** @test */
    public function it_can_show_the_login_page()
    {
        $this->assertGuest()
             ->get(route('canvas.login'))
             ->assertSuccessful()
             ->assertSeeText('Please sign in');
    }

    /** @test */
    public function it_can_validate_a_bad_login()
    {
        $user = factory(User::class)->create([
            'role' => User::ADMIN,
            'password' => Hash::make('password'),
        ]);

        $this->actingAs($user, 'canvas')
             ->post(route('canvas.login'), [
                 'email' => 'wrong@example.com',
                 'password' => 'password',
             ])
             ->assertSessionHasErrors();
    }

    /** @test */
    public function it_can_log_a_user_in()
    {
        $user = factory(User::class)->create([
            'role' => User::ADMIN,
            'password' => Hash::make('password'),
        ]);

        $this->actingAs($user, 'canvas')
             ->post(route('canvas.login'), [
                 'email' => $user->email,
                 'password' => 'password',
             ])
             ->assertRedirect(config('canvas.path'));
    }

    /** @test */
    public function it_can_log_a_user_out()
    {
        $user = factory(User::class)->create([
            'role' => User::ADMIN,
        ]);

        $this->actingAs($user, 'canvas')
             ->get(route('canvas.logout'))
             ->assertRedirect(route('canvas.login'));
    }
}
