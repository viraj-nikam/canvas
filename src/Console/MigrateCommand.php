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
    protected $signature = 'canvas:migrate
        { target=all : all, or a substring to match specific migration files (e.g., notes) }
        { --force : Force the operation to run when in production }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Canvas migrations (all or filtered)';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Resolve the package migrations path dynamically so it works for both
        // vendor installs and local path repositories (packages/{vendor}/canvas).
        $absolutePath = realpath(__DIR__.'/../../database/migrations');

        if (! $absolutePath) {
            $this->error('Could not resolve Canvas migrations path.');
            return;
        }

        $target = (string) $this->argument('target');

        // Laravel's --path expects a path relative to the base path (unless --realpath is used).
        $base = base_path().DIRECTORY_SEPARATOR;

        if ($target === 'all') {
            $relativePath = ltrim(str_replace($base, '', $absolutePath), DIRECTORY_SEPARATOR);

            $this->line("Running Canvas migrations from {$relativePath}...");
            $this->call('migrate', [
                '--path' => $relativePath,
                '--force' => (bool) ($this->option('force') ?? false),
            ]);
        } else {
            // Filter by substring in filename, run each matching migration file.
            $pattern = '/'.preg_quote($target, '/').'/i';
            $files = collect(glob($absolutePath.DIRECTORY_SEPARATOR.'*.php'))
                ->filter(function ($file) use ($pattern) {
                    return (bool) preg_match($pattern, basename($file));
                })
                ->values();

            if ($files->isEmpty()) {
                $this->warn("No Canvas migrations matched target '{$target}'.");
                return;
            }

            $this->line("Running Canvas migration(s) matching '{$target}'...");

            foreach ($files as $file) {
                $relativeFile = ltrim(str_replace($base, '', $file), DIRECTORY_SEPARATOR);
                $this->line("→ {$relativeFile}");
                $this->call('migrate', [
                    '--path' => $relativeFile,
                    '--force' => (bool) ($this->option('force') ?? false),
                ]);
            }
        }

        $this->info('Canvas migration(s) complete.');
    }
}
