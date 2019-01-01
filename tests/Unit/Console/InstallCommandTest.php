<?php

namespace Canvas\Tests\Unit\Console;

use Canvas\Tests\TestCase;

class InstallCommandTest extends TestCase
{
    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function it_can_install_assets_and_configuration()
    {
        $this->artisan('canvas:install')
            ->expectsOutput('Publishing Canvas assets...')
            ->expectsOutput('Publishing Canvas configuration...')
            ->expectsOutput('Running Canvas database migrations...')
            ->expectsOutput('Canvas is ready for use. Enjoy!')
            ->assertExitCode(0);
        $this->assertFileExists(config_path('canvas.php'));
        $this->assertDirectoryExists(public_path('vendor/canvas'));
    }
}
