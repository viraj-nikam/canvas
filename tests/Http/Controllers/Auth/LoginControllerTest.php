<?php

namespace Canvas\Tests\Http\Controllers\Auth;

use Canvas\Models\User;
use Canvas\Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * Class LoginControllerTest.
 *
 * @covers \Canvas\Http\Controllers\Auth\LoginController
 */
class LoginControllerTest extends TestCase
{
    public function testTheLoginPage(): void
    {
        $this->withoutMix();

        $this->assertGuest()
             ->get(route('canvas.login'))
             ->assertSuccessful()
             ->assertSeeText('Please sign in');
    }

    /** @test */
    public function testLoginRequestWillValidateAnInvalidEmail()
    {
        $response = $this->actingAs($this->admin, 'canvas')
             ->post(route('canvas.login'), [
                 'email' => 'wrong@example.com',
                 'password' => 'password',
             ])
             ->assertSessionHasErrors();

        $this->assertInstanceOf(ValidationException::class, $response->exception);
    }

    public function testSuccessfulLogin(): void
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('password'),
        ]);

        $this->actingAs($user, 'canvas')
             ->post(route('canvas.login'), [
                 'email' => $user->email,
                 'password' => 'password',
             ])
             ->assertRedirect(config('canvas.path'));
    }

    public function testSuccessfulLogout(): void
    {
        $this->actingAs($this->admin, 'canvas')
             ->get(route('canvas.logout'))
             ->assertRedirect(route('canvas.login'));
    }
}
