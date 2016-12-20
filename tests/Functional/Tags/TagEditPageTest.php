<?php

class TagEditPageTest extends TestCase
{
    use InteractsWithDatabase, CreatesUser;

    /** @test */
    public function it_can_edit_tags()
    {
        $this->actingAs($this->user)
            ->visit(route('admin.tag.edit', 1))
            ->type('Foo', 'title')
            ->press('Save')
            ->see('Success! Tag has been updated.')
            ->see('Foo')
            ->seeInDatabase('tags', ['title' => 'Foo']);
    }

    /** @test */
    public function it_can_delete_a_tag_from_the_database()
    {
        $this->actingAs($this->user)
            ->visit(route('admin.tag.edit', 1))
            ->press('Delete')
            ->dontSee('Success! Tag has been deleted.')
            ->press('Delete Tag')
            ->see('Success! Tag has been deleted.')
            ->dontSeeInDatabase('tags', ['id' => 1]);
    }
}
