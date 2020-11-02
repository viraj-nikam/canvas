<?php

namespace Canvas\Tests\Http\Controllers\Auth;

use Canvas\Mail\ResetPassword;
use Canvas\Tests\TestCase;
use Illuminate\Support\Facades\Mail;

/**
 * Class ForgotPasswordControllerTest.
 *
 * @covers \Canvas\Http\Controllers\Auth\ForgotPasswordController
 */
class ForgotPasswordControllerTest extends TestCase
{
    public function testTheForgotPasswordPage(): void
    {
        $this->withoutMix();

        $this->actingAs($this->admin, 'canvas')
             ->get(route('canvas.password.request'))
             ->assertSuccessful()
             ->assertViewIs('canvas::auth.passwords.email')
             ->assertSeeText('Send Password Reset Link');
    }

    public function testThePasswordResetLinkCanBeSent(): void
    {
        Mail::fake();

        $this->actingAs($this->admin, 'canvas')
             ->post(route('canvas.password.email'), [
                 'email' => $this->admin->email,
             ])
             ->assertRedirect(route('canvas.password.request'));

        Mail::assertSent(ResetPassword::class, function ($mail) {
            $this->assertIsString($mail->token);

            return $mail->hasTo($this->admin->email);
        });
    }
}
