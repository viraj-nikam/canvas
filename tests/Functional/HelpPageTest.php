<?php

class HelpPageTest extends TestCase
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
        $this->user = factory(App\Models\User::class)->create();
    }

    /** @test */
    public function it_can_refresh_the_user_page()
    {
        $this->actingAs($this->user)
            ->visit('/admin/help')
            ->click('Refresh Help');
        $this->assertSessionMissing('errors');
        $this->seePageIs('/admin/help');
    }
}
