<?php

namespace Vkovic\LaravelCommandos\Console\Commands;

use Illuminate\Console\Command;
use Vkovic\LaravelCommandos\Handlers\Database\AbstractDbHandler;
use Vkovic\LaravelCommandos\Handlers\Helper;

class DbSummonCommand extends Command
{
    /**
     * @var AbstractDbHandler
     */
    protected $dbHandler;

    /**
     * @var Helper
     */
    protected $appHandler;

    protected $signature = 'db:summon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop default database, than perform migrate followed with the seed';

    public function __construct(AbstractDbHandler $dbHandler, Helper $appHandler)
    {
        parent::__construct();

        $this->dbHandler = $dbHandler;
        $this->appHandler = $appHandler;
    }

    public function handle()
    {
        // TODO
        // Prevent on production
        // or make it run only if `--force` flag is passed

        $database = config('database.connections.' . config('database.default') . '.database');

        $this->output->warning('This command will:');
        $this->output->listing([
            "drop database `$database` if one exists",
            "create empty database `$database`",
            "migrate database (same as `php artisan migrate`)",
            "seed database (same as `php artisan db:seed`)",
        ]);

        if (!$this->confirm('Do you really wish to continue?')) {
            $this->output->note('Command aborted');

            return 255;
        }

        if ($this->dbHandler->databaseExists($database)) {
            $this->dbHandler->dropDatabase($database);
        }

        $this->dbHandler->createDatabase($database);

        $this->appHandler->artisanCall('migrate');
        $this->appHandler->artisanCall('db:seed');

        $this->output->success("Database `$database` summoned successfully");
    }
}
