<?php

namespace Canvas\Tests\Http\Controllers\Auth;

use Canvas\Models\User;
use Canvas\Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * Class AuthenticatedSessionControllerTest.
 *
 * @covers \Canvas\Http\Controllers\Auth\AuthenticatedSessionController
 * @covers \Canvas\Http\Requests\LoginRequest
 */
class AuthenticatedSessionControllerTest extends TestCase
{
    public function testTheLoginPage(): void
    {
        $this->withoutMix();

        $this->assertGuest()
             ->get(route('canvas.login'))
             ->assertSuccessful()
             ->assertSeeText('Please sign in');
    }

    public function testLoginRequestWillValidateAnInvalidEmail(): void
    {
        $response = $this->post('/canvas/login', [
            'email' => 'wrong@example.com',
            'password' => 'password',
        ])->assertSessionHasErrors();

        $this->assertInstanceOf(ValidationException::class, $response->exception);
    }

    public function testSuccessfulLogin(): void
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('password'),
        ]);

        $this->post('/canvas/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(config('canvas.path'));
    }

    public function testSuccessfulLogout(): void
    {
        $this->actingAs($this->admin, 'canvas')
             ->get(route('canvas.logout'))
             ->assertRedirect(route('canvas.login'));
    }
}
