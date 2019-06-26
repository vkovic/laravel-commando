<?php

namespace Vkovic\LaravelCommandos\Console\Commands;

use Illuminate\Console\Command;
use Vkovic\LaravelCommandos\Handlers\Artisan\WithArtisanHandler;
use Vkovic\LaravelCommandos\Handlers\Database\WithDbHandler;

class DbSummonCommand extends Command
{
    use WithArtisanHandler, WithDbHandler;

    protected $signature = 'db:summon
                                {database? : Which database to use as import destination. Db from env will be used if none passed}
                           ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Empty DB, than perform migrate and seed';

    public function handle()
    {
        // TODO
        // Prevent on production
        $database = $this->argument('database') ?: (function () {
            $default = config('database.default');

            return config("database.connections.$default.database");
        })();

        if ($this->dbHandler()->databaseExists($database)) {
            $this->dbHandler()->dropDatabase($database);
        }

        $this->dbHandler()->createDatabase($database);

        $this->artisanHandler()->call('migrate');
        $this->artisanHandler()->call('db:seed');

        // Success message
        $this->info('Done');
    }
}
