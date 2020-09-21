<?php

namespace Canvas\Tests\Console;

use Canvas\Models\User;
use Canvas\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class InstallCommandTest.
 *
 * @covers \Canvas\Console\InstallCommand
 */
class InstallCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_install_all_of_the_canvas_resources()
    {
        $this->artisan('canvas:install')
             ->assertExitCode(0)
             ->expectsOutput('Installation complete.');

        $this->assertDatabaseHas('canvas_users', [
            'email' => 'email@example.com',
            'role' => User::ADMIN,
        ]);
    }
}
