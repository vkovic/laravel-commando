<?php

namespace Vkovic\LaravelCommandos\Console\Commands\Database;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Vkovic\LaravelCommandos\Handlers\Console\WithConsoleHandler;

class DbDump extends Command
{
    use WithConsoleHandler, ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:dump 
                                {--force : Force the operation to run when in production.}
                           ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dump default (env defined) database without db prefix and view definer';

    public function handle()
    {
        // TODO
        // Implement arguments that user can pass to customize dump process.
        // Also add easy gzip fn

        $user = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $database = env('DB_DATABASE');
        $host = env('DB_HOST');
        $dump = storage_path('dump.sql');

        // Omit view definer so we do not come across missing user on another system
        $removeDefiner = "| sed -e 's/DEFINER[ ]*=[ ]*[^*]*\*/\*/'";

        // Avoid database prefix being written into dump file
        $removeDbPrefix = "| sed -e 's/`$database`.`/`/g'";

        $command = "mysqldump -h $host -u$user -p$password $database $removeDefiner $removeDbPrefix > $dump";

        $this->consoleHandler()->executeCommand($command);
    }
}
