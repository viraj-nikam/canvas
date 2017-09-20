<?php

namespace Tests\Unit\Pages\Help;

use Tests\TestCase;
use Tests\CreatesUser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HelpIndexPageTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions, CreatesUser;

    /** @test */
    public function it_can_refresh_the_user_page()
    {
        Auth::guard('canvas')->login($this->user);
        $this->actingAs($this->user)
            ->visit(route('canvas.admin.help'))
            ->click('Refresh Help');
        $this->assertSessionMissing('errors');
        $this->seePageIs(route('canvas.admin.help'));
    }
}
