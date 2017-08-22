<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Tests\CreatesUser;
use Tests\InteractsWithDatabase;
use Illuminate\Support\Facades\Auth;

class AuthenticationTest extends TestCase
{
    use InteractsWithDatabase, CreatesUser;

    /** @test */
    public function it_validates_no_data_entered_in_login_form()
    {
        // Actions
        $this->visit(route('canvas.admin'))
            ->type('', 'email')
            ->type('', 'password')
            ->press('submit');

        // Assertions
        $this->dontSeeIsAuthenticated()
            ->seePageIs(route('canvas.admin'))
            ->assertResponseOk()
            ->see('The email field is required.')
            ->see('The password field is required.');
    }

    /** @test */
    public function it_validates_incorrect_data_entered_in_login_form()
    {
        // Actions
        $this->visit(route('canvas.admin'))
            ->type('foo@bar.com', 'email')
            ->type('secret', 'password')
            ->press('submit');

        // Assertions
        $this->dontSeeIsAuthenticated()
            ->seePageIs(route('canvas.admin'))
            ->assertResponseOk()
            ->see('These credentials do not match our records.');
    }

    /** @test */
    public function it_validates_no_data_entered_in_forgot_password_form()
    {
        // Actions
        $this->visit(route('canvas.auth.password.forgot'))
            ->type('', 'email')
            ->press('submit');

        // Assertions
        $this->seePageIs(route('canvas.auth.password.forgot'))
            ->assertResponseOk()
            ->see('The email field is required.');
    }

    /** @test */
    public function it_validates_incorrect_data_entered_in_forgot_password_form()
    {
        // Actions
        $this->visit(route('canvas.auth.password.forgot'))
            ->type('foo@bar.com', 'email')
            ->press('submit');

        // Assertions
        $this->seePageIs(route('canvas.auth.password.forgot'))
            ->assertResponseOk()
            ->see('We can\'t find a user with that e-mail address.');
    }

    /** @test */
    public function it_can_login_to_the_application()
    {
        // Actions
        $this->visit(route('canvas.admin'))
            ->type($this->user->email, 'email')
            ->type('password', 'password')
            ->press('submit');

        // Assertions
        $this->seeIsAuthenticated()
            ->seePageIs(route('canvas.admin'))
            ->assertResponseOk()
            ->see('Welcome to Canvas');
    }

    /** @test */
    public function it_can_logout_of_the_application()
    {
        // Setup
        Auth::guard('canvas')->login($this->user);

        // Actions
        $this->visit(route('canvas.admin'))
            ->click('Sign out');

        // Assertions
        $this->dontSeeIsAuthenticated()
            ->seePageIs(route('canvas.admin'))
            ->assertResponseOk()
            ->see('Sign In');
    }
}
