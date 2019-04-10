<?php

namespace Canvas\Console;

use Canvas\Exporter;
use Illuminate\Console\Command;
use Illuminate\Foundation\Auth\User;

class ExportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'canvas:export {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export all shared data for a user';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::find($this->argument('user'));

        if ($user) {
            resolve(Exporter::class)
                ->forUser($user)
                ->exportTo(config('canvas.storage_disk'))
                ->download();
        }
    }
}
