<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database using mysqldump';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filename = "backup-" . date('Y-m-d_H-i-s') . ".sql";
        
        $storagePath = storage_path('app/backups');
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0755, true);
        }

        $command = sprintf(
            'mysqldump --user="%s" --password="%s" --host="%s" "%s" > "%s"',
            config('database.connections.mysql.username'),
            config('database.connections.mysql.password'),
            config('database.connections.mysql.host'),
            config('database.connections.mysql.database'),
            $storagePath . '/' . $filename
        );

        $returnVar = NULL;
        $output  = NULL;

        exec($command, $output, $returnVar);

        if ($returnVar === 0) {
            $this->info("Database backup created successfully: {$filename}");
            Log::info("Database backup created: {$filename}");

            // Keep only the last 7 backups to save space
            $files = glob($storagePath . '/backup-*.sql');
            if (count($files) > 7) {
                array_multisort(
                    array_map('filemtime', $files), SORT_NUMERIC, SORT_DESC, $files
                );
                $filesToDelete = array_slice($files, 7);
                foreach ($filesToDelete as $file) {
                    unlink($file);
                    Log::info("Deleted old backup: " . basename($file));
                }
            }
        } else {
            $this->error("Database backup failed.");
            Log::error("Database backup failed. Command: {$command}");
        }
    }
}
