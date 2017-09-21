<?php

namespace Tests\Unit\Pages\Posts;

use Canvas\Models\Post;
use Tests\TestCase;
use Tests\TestHelper;
use Tests\CreatesUser;
use Tests\InteractsWithDatabase;

class PostEditPageTest extends TestCase
{
    use InteractsWithDatabase, TestHelper, CreatesUser;

    /** @test */
    public function it_can_edit_posts()
    {
        $this->createUser()->callRouteAsUser('canvas.admin.post.edit', 1)
            ->submitForm('Update', ['title' => 'Foo'])
            ->see('Success! Post has been updated')
            ->see('Foo')
            ->seePostInDatabase();
    }

    /** @test */
    public function it_can_preview_a_post()
    {
        $this->createUser()->callRouteAsUser('canvas.admin.post.edit', 1)
            ->click('permalink')
            ->seePageIs(route('canvas.blog.post.show', 'hello-world'))
            ->assertSessionMissing('errors');
    }

    /** @test */
    public function it_can_delete_a_post_from_the_database()
    {
        $this->createUser()->callRouteAsUser('canvas.admin.post.edit', 1)
            ->press('Delete Post')
            ->see($this->getDeleteMessage())
            ->dontSeePostInDatabase(1)
            ->seePageIs(route('canvas.admin.post.index'))
            ->assertSessionMissing('errors');
    }

    /**
     * Get the post deletion success message.
     *
     * @return string
     */
    protected function getDeleteMessage()
    {
        return 'Success! Post has been deleted.';
    }
}