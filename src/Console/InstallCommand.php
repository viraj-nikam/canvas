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
    protected $description = 'Install all of the Canvas resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Publishing Canvas assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'assets']);

        $this->comment('Publishing Canvas configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'config']);

        $this->info('Canvas scaffolding installed successfully.');
    }
}
