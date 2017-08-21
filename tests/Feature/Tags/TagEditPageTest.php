<?php

namespace Tests\Feature\Tag;

use Tests\TestCase;
use Tests\TestHelper;
use Tests\CreatesUser;
use Canvas\Helpers\CanvasHelper;
use Tests\InteractsWithDatabase;

class TagEditPageTest extends TestCase
{
    use InteractsWithDatabase, CreatesUser, TestHelper;

    /** @test */
    public function it_can_edit_tags()
    {
        Auth::guard('canvas')->login($this->user);
        $this->callRouteAsUser('canvas.admin.tag.edit', 1)
            ->type('Foo', 'title')
            ->press('Save')
            ->see('Foo')
            ->seeInDatabase(CanvasHelper::TABLES['tags'], ['title' => 'Foo'])
            ->assertSessionMissing('errors');
    }

    /** @test */
    public function it_can_delete_a_tag_from_the_database()
    {
        Auth::guard('canvas')->login($this->user);
        $this->callRouteAsUser('canvas.admin.tag.edit', 1)
            ->press('Delete Tag')
            ->see('Success! Tag has been deleted.')
            ->dontSeeTagInDatabase(CanvasHelper::TABLES['tags'], ['id' => 1])
            ->assertSessionMissing('errors');
    }
}
