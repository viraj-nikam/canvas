<?php

class UpdatePasswordTest extends TestCase
{
    use InteractsWithDatabase;

    /**
     * The user model.
     *
     * @var App\Models\User
     */
    private $user;

    /**
     * Create the user model test subject.
     *
     * @before
     * @return void
     */
    public function createUser()
    {
        $this->user = factory(App\Models\User::class)->create([
            'email'     => 'foo@bar.com',
            'password'  => bcrypt('password'),
        ]);
    }

    /** @test */
    public function it_validates_the_current_password()
    {
        $this->actingAs($this->user)->post('auth/password', [
            'password'                  => 'wrongPass',
            'new_password'              => 'newPass',
            'new_password_confirmation' => 'newPass',
        ]);

        $this->assertEquals(Session::get('errors')->first(), trans('auth.failed'));
    }

    /** @test */
    public function it_can_update_the_password()
    {
        $this->actingAs($this->user)->post('auth/password', [
            'password'                  => 'password',
            'new_password'              => 'newPass',
            'new_password_confirmation' => 'newPass',
        ]);

        $this->assertSessionMissing('errors');
        $this->assertTrue(Auth::validate([
            'email'    => $this->user->email,
            'password' => 'newPass',
        ]));
    }
}
