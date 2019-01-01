<?php

namespace Canvas\Console;

use Illuminate\Console\Command;

class MigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'canvas:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the database migrations for Canvas';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Running Canvas database migrations...');
        $this->callSilent('migrate');

        $this->line('');
        $this->line('Canvas is ready for use. Enjoy!');
    }
}
