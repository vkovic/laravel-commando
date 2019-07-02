<?php

namespace Vkovic\LaravelCommandos\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Vkovic\LaravelCommandos\Handlers\Database\WithDbHandler;

class ModelFieldsCommand extends Command
{
    use WithDbHandler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'model:fields
                                {model? : Model namespace, e.g. `"App\User"` or `"App\Models\User"`)}
                           ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'TODO';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $database = config('database.connections.' . config('database.default') . '.database');

        // Take model from passed argument
        // or list all models within the app
        if (($modelClass = $this->argument('model')) === null) {
            $allModels = $this->getAllModelClasses();
            $modelClass = $this->choice('Choose model to show the fields from:', $allModels);
        }

        if (!class_exists($modelClass)) {
            $this->output->warning("Model `$modelClass` doesn`t exist");

            return 1;
        }

        $modelClass = ltrim($modelClass, '\\');

        /** @var Model $model */
        $model = new $modelClass;
        $casts = $model->getCasts();
        $fillable = $model->getFillable();
        $guarded = $model->getGuarded();

        // Array with: name, position, type, nullable, default_value
        $columns = $this->dbHandler()->getColumns($database, $model->getTable());

        $data = [];
        foreach ($columns as $i => $column) {
            $data[$i] = [
                $column['name'],
                $column['type'],
                $column['nullable'] ? 'YES' : '',
                $column['default_value'] ?? '',
                $casts[$column['name']] ?? '', // Casts
                in_array($column['name'], $guarded) ? 'YES' : '', // Guarded
                in_array($column['name'], $fillable) ? 'YES' : '' // Fillable
            ];
        }

        $this->output->text("Model: `$modelClass`");
        $this->table(['Field', 'Type', 'Nullable', 'Default', 'Casts', 'Guarded', 'Fillable'], $data);
        $this->output->newLine();
    }

    protected function getAllModelClasses()
    {
        $appNamespace = \Illuminate\Container\Container::getInstance()->getNamespace();
        $appPath = app_path();

        $allFiles = File::allFiles($appPath);

        $modelClasses = [];
        foreach ($allFiles as $file) {
            $relPath = $file->getRealPath();

            if (!$this->isClass($relPath)) {
                continue;
            }

            $pathWithoutExtension = str_replace('.php', '', $relPath);
            $pathWithoutAppPath = ltrim($pathWithoutExtension, $appPath);
            $class = $appNamespace . str_replace('/', '\\', $pathWithoutAppPath);

            if ($this->isAbstractClass($class) || $this->isInterface($class)) {
                continue;
            }

            if (is_subclass_of($class, Model::class)) {
                $modelClasses[] = $class;
            }
        }

        return $modelClasses;
    }

    /**
     * Check if given file is a PHP class
     *
     * @param $file
     *
     * @return bool
     */
    protected function isClass($file)
    {
        $tokens = token_get_all(file_get_contents($file), TOKEN_PARSE);

        foreach ($tokens as $token) {
            if (is_array($token) && token_name($token[0]) == 'T_CLASS') {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if given class is abstract
     *
     * @param $class
     *
     * @return bool
     * @throws \ReflectionException
     */
    protected function isAbstractClass($class)
    {
        return (new \ReflectionClass($class))->isAbstract();
    }

    protected function isInterface($class)
    {
        return (new \ReflectionClass($class))->isInterface();
    }
}
