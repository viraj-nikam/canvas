<?php

class TagIndexPageTest extends TestCase
{
    use InteractsWithDatabase, CreatesUser;

    /** @test */
    public function it_can_refresh_the_tag_page()
    {
        $this->actingAs($this->user)
            ->visit('/admin/tag')
            ->click('Refresh Tags');
        $this->assertSessionMissing('errors');
        $this->seePageIs('/admin/tag');
    }

    /** @test */
    public function it_can_add_a_tag_from_the_tag_index_page()
    {
        $this->actingAs($this->user)
            ->visit('/admin/tag')
            ->click('create-tag');
        $this->assertSessionMissing('errors');
        $this->seePageIs('/admin/tag/create');
    }
}
