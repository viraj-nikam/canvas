<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfilePageTest extends TestCase
{
    use DatabaseMigrations;

    protected $optionalFields = [
        'bio' => 'Summary',
        'gender' => '<dt>Gender</dt>',
        'birthday' => '<dt>Birthday</dt>',
        'relationship' => '<dt>Relationship Status</dt>',
        'phone' => '<dt>Mobile Phone</dt>',
        'twitter' => '<dt>Twitter</dt>',
        'facebook' => '<dt>Facebook</dt>',
        'github' => '<dt>GitHub</dt>',
        'linkedin' => '<dt>LinkedIn</dt>',
        'resume_cv' => '<dt>Resume/CV</dt>',
        'url' => '<dt>Website</dt>',
        'address' => '<dt>Address</dt>',
        'city' => '<dt>City</dt>',
        'country' => '<dt>Country</dt>',
    ];

    protected $requiredFields = [
        'first_name',
        'last_name',
        'display_name',
        'email',
    ];

    /** @test */
    public function it_shows_error_messages_for_required_fields()
    {
        $this->actingAs(factory(App\Models\User::class)->create())
            ->visit('/admin/profile');

        // Fill in all of the required fields with an empty string
        foreach ($this->requiredFields as $name) {
            $this->type('', $name);
        }

        $this->press('Save');

        // Assert response contains an error message for each field
        foreach ($this->requiredFields as $name) {
            $this->see('The '.str_replace('_', ' ', $name).' field is required.');
        }
    }
}
