<?php

namespace Canvas\Console;

use Canvas\Models\User;
use Illuminate\Console\Command;

class AdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'canvas:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grant admin access to a specific user';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $email = $this->ask('Enter the email of the user to grant admin access to');

        if (! $email) {
            $this->error('Please enter a valid email.');

            return;
        }

        $user = User::firstWhere('email', $email);

        if (! $user) {
            $this->error('Unable to find a user with that email.');

            return;
        }

        if ($user->isAdmin) {
            $this->info('User is already an admin.');

            return;
        }

        $user->role = User::ADMIN;

        $user->save();

        $this->info('Access granted.');
    }
}
