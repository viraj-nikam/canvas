<?php

namespace Tests\Feature\Auth;

use Canvas\Models\User;
use Tests\DuskTestCase;
use Tests\InteractsWithDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthenticationTest extends DuskTestCase
{
    use InteractsWithDatabase, DatabaseTransactions;

    /**
     * The User model.
     *
     * @var User
     */
    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function it_validates_the_login_form()
    {
        // User entered nothing
        $this->browse(function ($browser) {
            $browser->visit(route('canvas.admin'))
                ->with('#login', function ($form) {
                    $form->type('email', '')
                        ->type('password', '')
                        ->press('submit');
                });
            $browser->assertTitleContains('Sign In')
                ->assertSee('The email field is required.')
                ->assertSee('The password field is required.');

            // User entered wrong email
            $browser->visit(route('canvas.admin'))
                ->with('#login', function ($form) {
                    $form->type('email', 'foo@bar.com')
                        ->type('password', 'secret')
                        ->press('submit');
                });
            $browser->assertTitleContains('Sign In')
                ->assertSee('These credentials do not match our records.');
        });
    }

    /** @test */
    public function it_validates_the_forgot_password_form()
    {
        $this->browse(function ($browser) {
            // User entered nothing
            $browser->visit(route('canvas.auth.password.forgot'))
                ->with('#forgot-password', function ($form) {
                    $form->type('email', '')
                        ->press('submit');
                });
            $browser->assertTitleContains('Forgot Password')
                ->assertSee('The email field is required.');

            // User entered wrong email
            $browser->visit(route('canvas.auth.password.forgot'))
                ->with('#forgot-password', function ($form) {
                    $form->type('email', 'foo@bar.com')
                        ->press('submit');
                });
            $browser->assertTitleContains('Forgot Password')
                ->assertSee('We can\'t find a user with that e-mail address.');
        });
    }

    /** @test */
    public function it_can_login_to_the_application()
    {
        $this->browse(function ($browser) {
            $browser->visit(route('canvas.admin'))
                ->with('#login', function ($form) {
                    $form->type('email', $this->user->email)
                        ->type('password', 'password')
                        ->press('submit');
                });
            $this->assertTrue(Auth::check(), true);
            $browser->assertSee('Welcome to Canvas!');
        });
    }

    /** @test */
    public function it_can_logout_of_the_application()
    {
        Auth::guard('canvas')->login($this->user);
        $this->browse(function ($browser) {
            $browser->visit(route('canvas.admin'))
                ->clickLink('Sign out');

            $browser->assertTitleContains('Sign In');
        });
    }
}