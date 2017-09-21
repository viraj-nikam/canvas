<?php

namespace Tests\Unit\Pages\Posts;

use Tests\TestCase;
use Tests\CreatesUser;
use Tests\InteractsWithDatabase;

class PostIndexPageTest extends TestCase
{
    use InteractsWithDatabase, CreatesUser;

    /** @test */
    public function it_can_refresh_the_post_page()
    {
        $this->createUser()->actingAs($this->user)
            ->visit(route('canvas.admin.post.index'))
            ->click('Refresh Posts');
        $this->assertSessionMissing('errors');
        $this->seePageIs(route('canvas.admin.post.index'));
    }

    /** @test */
    public function it_can_add_a_post_from_the_post_index_page()
    {
        $this->createUser()->actingAs($this->user)
            ->visit(route('canvas.admin.post.index'))
            ->click('create-post');
        $this->assertSessionMissing('errors');
        $this->seePageIs(route('canvas.admin.post.create'));
    }

    /** @test */
    public function it_applies_a_draft_label_to_a_non_published_post()
    {
        $this->createUser()->actingAs($this->user)
            ->visit(route('canvas.admin'))
            ->type('example', 'title')
            ->type('foo', 'slug')
            ->type('bar', 'subtitle')
            ->type('FooBar', 'content')
            ->type('example', 'title')
            ->type(\Carbon\Carbon::now(), 'published_at')
            ->type(config('blog.post_layout'), 'layout')
            ->check('is_published')
            ->press('Save');
        $this->assertSessionMissing('errors');
        $this->visit(route('canvas.admin.post.index'))
            ->see('<td>&lt;span class="label label-primary"&gt;Published&lt;/span&gt;</td>');
    }
}
