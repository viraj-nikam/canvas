<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class UpdateSettingsTest extends TestCase
{
    use DatabaseMigrations;

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

    protected $optionalFields = [
        'blog_description' => '<dt>Description</dt>',
        'blog_seo' => '<dt>Blog SEO</dt>',
        'blog_author' => '<dt>Blog Author</dt>',
        'disqus_name' => '<dt>Disqus</dt>',
        'ga_id' => '<dt>Google Analytics</dt>',
    ];

    protected $requiredFields = [
        'blog_title',
        'blog_subtitle',
    ];

    /** @test */
    public function it_shows_error_messages_for_required_fields()
    {
        $this->actingAs($this->user)
            ->visit('/admin/settings');

        // Fill in all of the required fields with an empty string
        foreach ($this->requiredFields as $name) {
            $this->type('', $name);
        }

        $this->press('Save');

        // Assert the response contains an error message for each field
        foreach ($this->requiredFields as $name) {
            $this->see('The '.str_replace('_', ' ', $name).' field is required.');
        }
    }

    /** @test */
    public function it_can_update_the_settings()
    {
        $this->actingAs($this->user)
            ->visit('/admin/settings');

        $this->type('New and Updated Title', 'blog_title')
            ->press('Save');

        $this->assertSessionMissing('errors');

        $this->seePageIs('admin/settings');
    }
}
