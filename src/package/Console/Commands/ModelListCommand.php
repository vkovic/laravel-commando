<?php

namespace Vkovic\LaravelCommandos\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Vkovic\LaravelCommandos\Handlers\Database\AbstractDbHandler;
use Vkovic\LaravelCommandos\Handlers\Helper;

class ModelListCommand extends Command
{
    /**
     * @var AbstractDbHandler
     */
    protected $dbHandler;

    /**
     * @var Helper
     */
    protected $helper;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'model:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show all models and tables they use';

    public function __construct(AbstractDbHandler $dbHandler, Helper $helper)
    {
        parent::__construct();

        $this->dbHandler = $dbHandler;
        $this->helper = $helper;
    }

    public function handle()
    {
        $allModels = $this->helper->getAllModelClasses();

        $rows = [];
        $previousNamespace = '';
        foreach ($allModels as $i => $modelClass) {
            $modelClass = ltrim($modelClass, '\\');

            $namespace = explode('\\', $modelClass);
            array_pop($namespace);
            $namespace = implode('\\', $namespace);

            /** @var Model $model */
            $model = new $modelClass;

            $table = $model->getTable();

            $tableCount = \DB::table($table)->count();

            // Count records
            if (method_exists($model, 'getDeletedAtColumn')) {
                $scopedCount = $model::count();
                $softDeleted = $model::withTrashed()->whereNotNull('deleted_at')->count();
            } else {
                $scopedCount = $model::count();
                $softDeleted = '';
            }

            // Separate rows by new namespace
            if ($namespace != $previousNamespace && $previousNamespace != '') {
                $rows[] = [''];
            }
            $previousNamespace = $namespace;

            $rows[] = [
                $modelClass, $table, $tableCount, $scopedCount, $softDeleted
            ];
        }

        $this->output->newLine();
        $this->table(['Model', 'Table', 'Table count', 'Scope count', 'Soft deleted'], $rows);
        $this->output->newLine();
    }
}
