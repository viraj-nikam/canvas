<?php

namespace Canvas\Tests\Http\Controllers\Auth;

use Canvas\Tests\TestCase;
use Illuminate\Support\Str;

/**
 * Class ResetPasswordControllerTest.
 *
 * @covers \Canvas\Http\Controllers\Auth\ResetPasswordController
 */
class ResetPasswordControllerTest extends TestCase
{
    public function testTheResetPasswordPage(): void
    {
        $this->withoutMix();

        $this->actingAs($this->admin, 'canvas')
             ->get(route('canvas.password.reset', [
                 'token' => Str::random(60),
             ]))
             ->assertSuccessful()
             ->assertViewIs('canvas::auth.passwords.reset')
             ->assertSeeText('Reset password');
    }
}
