<?php

namespace Canvas\Tests\Mail;

use Canvas\Mail\ResetPassword;
use Canvas\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

/**
 * Class ResetPasswordTest.
 *
 * @covers \Canvas\Mail\ResetPassword
 */
class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_build_a_mailable()
    {
        $token = Str::random(60);

        $mailable = new ResetPassword($token);

        $this->assertInstanceOf(ResetPassword::class, $mailable->build());
    }
}
