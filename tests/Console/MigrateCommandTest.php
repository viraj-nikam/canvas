<?php

namespace Canvas\Tests\Console;

use Canvas\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class MigrateCommandTest.
 *
 * @covers \Canvas\Console\MigrateCommand
 */
class MigrateCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_run_canvas_migrations()
    {
        $this->artisan('canvas:migrate')
             ->assertExitCode(0)
             ->expectsOutput('Migration complete.');
    }
}
