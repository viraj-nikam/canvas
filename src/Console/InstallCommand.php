<?php

namespace Canvas\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'canvas:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Canvas and all of its resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Publishing the assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'canvas-assets']);

        $this->comment('Publishing the configuration file...');
        $this->callSilent('vendor:publish', ['--tag' => 'canvas-config']);

        $this->comment('Running the database migrations...');
        $this->callSilent('migrate');

        $this->line('');
        $this->line('<info>[✔]</info> Canvas is installed and ready to use. Enjoy!');
    }
}
