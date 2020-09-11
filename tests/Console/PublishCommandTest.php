<?php

namespace Canvas\Tests\Console;

use Canvas\Tests\TestCase;

/**
 * Class PublishCommandTest.
 *
 * @covers \Canvas\Console\PublishCommand
 */
class PublishCommandTest extends TestCase
{
    /** @test */
    public function it_can_publish_canvas_assets()
    {
        // No idea why this prints out 3 times here... ¯\_(ツ)_/¯
        $this->artisan('canvas:publish')
             ->assertExitCode(0)
             ->expectsOutput('Publishing complete.')
             ->expectsOutput('Publishing complete.')
             ->expectsOutput('Publishing complete.');
    }
}
