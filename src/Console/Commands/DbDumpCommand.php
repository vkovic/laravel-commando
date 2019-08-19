<?php

namespace Vkovic\LaravelCommando\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Vkovic\LaravelCommando\Handlers\Console\WithConsoleHandler;
use Vkovic\LaravelCommando\Handlers\Database\WithDbHandler;

class DbDumpCommand extends Command
{
    use WithDbHandler, WithConsoleHandler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:dump
                                {database? : Database to dump. If omitted, name from .env will be used.}
                                {--dir= : Directory for dump creation. If omitted default filesystem dir will be used.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dump database to `.sql` file';

    public function handle()
    {
        // TODO
        // Implement arguments that user can pass to customize dump process (like gz) ...

        $database = $this->argument('database')
            ?: config('database.connections.' . config('database.default') . '.database');

        $dir = $this->option('dir')
            ?: config('filesystems.disks.' . config('filesystems.default') . '.root');

        if (!$this->dbHandler()->databaseExists($database)) {
            $this->output->warning("Database `$database` doesn`t exist");

            return 1;
        }

        $user = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');
        $destination = $dir . DIRECTORY_SEPARATOR . "$database-" . Carbon::now()->format('Y-m-d-H-i-s') . '.sql';

        // Omit view definer so we do not come across missing user on another system
        $removeDefiner = "| sed -e 's/DEFINER[ ]*=[ ]*[^*]*\*/\*/'";

        // Avoid database prefix being written into dump file
        $removeDbPrefix = "| sed -e 's/`$database`.`/`/g'";

        $command = "mysqldump -h $host -u$user -p$password $database $removeDefiner $removeDbPrefix > $destination";

        $this->consoleHandler()->executeCommand($command);

        $this->output->success("Database `$database` dumped successfully");
        $this->output->text("Destination: `$destination`");
        $this->output->newLine();
    }
}
