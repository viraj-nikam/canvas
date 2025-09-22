<?php

namespace Canvas\Console;

use Canvas\Models\Note;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;

class EncryptNotesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'canvas:encrypt-notes
        {--chunk=100 : Number of records to process per chunk}
        {--dry-run : Scan and report, but do not write changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Encrypt existing Canvas note bodies at rest';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $chunk = (int) $this->option('chunk') ?: 100;
        $dryRun = (bool) $this->option('dry-run');

        $query = Note::query()->whereNotNull('body');
        $total = (clone $query)->count();

        if ($total === 0) {
            $this->info('No notes with bodies found.');
            return self::SUCCESS;
        }

        $this->line("Scanning {$total} notes in chunks of {$chunk}...");

        $alreadyEncrypted = 0;
        $encrypted = 0;
        $skipped = 0;

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $query->orderBy('id')->chunkById($chunk, function ($notes) use (&$alreadyEncrypted, &$encrypted, &$skipped, $dryRun, $bar) {
            foreach ($notes as $note) {
                $raw = $note->getRawOriginal('body');

                if ($raw === null || $raw === '') {
                    $skipped++;
                    $bar->advance();
                    continue;
                }

                // If decrypt succeeds, body is already encrypted
                $isEncrypted = false;
                try {
                    Crypt::decryptString($raw);
                    $isEncrypted = true;
                } catch (\Throwable $e) {
                    $isEncrypted = false;
                }

                if ($isEncrypted) {
                    $alreadyEncrypted++;
                    $bar->advance();
                    continue;
                }

                if (! $dryRun) {
                    // Encrypt without altering timestamps or firing events
                    $note->timestamps = false;
                    $note->body = $raw; // setter will encrypt
                    $note->saveQuietly();
                    $note->timestamps = true;
                }

                $encrypted++;
                $bar->advance();
            }
        });

        $bar->finish();
        $this->newLine(2);

        $this->info('Encryption scan complete.');
        $this->line("Already encrypted: {$alreadyEncrypted}");
        $this->line(($dryRun ? 'Would encrypt' : 'Encrypted').": {$encrypted}");
        $this->line("Skipped (empty): {$skipped}");

        if ($dryRun && $encrypted > 0) {
            $this->comment('Run again without --dry-run to persist encryption.');
        }

        return self::SUCCESS;
    }
}

