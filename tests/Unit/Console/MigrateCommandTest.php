<?php

namespace Canvas\Tests\Unit\Console;

use Canvas\Tests\TestCase;

class MigrateCommandTest extends TestCase
{
    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function it_can_run_database_migrations()
    {
        $this->artisan('canvas:migrate')
            ->expectsOutput('Running Canvas database migrations...')
            ->expectsOutput('Canvas is ready for use. Enjoy!')
            ->assertExitCode(0);
    }
}
