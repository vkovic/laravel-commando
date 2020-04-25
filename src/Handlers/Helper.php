<?php

namespace Vkovic\LaravelCommando\Handlers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class Helper
{
    /**
     * Get app namespace
     *
     * @return string
     */
    public function getAppNamespace()
    {
        return \Illuminate\Container\Container::getInstance()->getNamespace();
    }

    /**
     * Get application path
     *
     * @return string
     */
    public function getAppPath()
    {
        return app_path();
    }

    public function artisanCall($command, array $parameters = [], $outputBuffer = null)
    {
        return Artisan::call($command, $parameters, $outputBuffer);
    }

    /**
     * Get all model classes from the application (root app path)
     *
     * @return array
     *
     * @throws \Exception
     */
    public function getAllModelClasses()
    {
        $appNamespace = $this->getAppNamespace();
        $appPath = $this->getAppPath();

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

            // If some of the classes is not in correct namespace
            // or has wrong name or file path (PSR-4 compatibility)
            // ReflectionException: Class X\Y\Class does not exist will be thrown
            try {
                if ($this->isAbstractClass($class) || $this->isInterface($class)) {
                    continue;
                }
            } catch (\Exception $e) {
                $message = $e->getMessage();
                $message .= ' or not PSR-4 compatible.' . PHP_EOL;
                $message .= 'Check class name, namespace and class file location.';

                throw new \Exception($message);
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
    public function isClass($file)
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
     * @param string $class
     *
     * @return bool
     *
     * @throws \ReflectionException
     */
    public function isAbstractClass($class)
    {
        return (new \ReflectionClass($class))->isAbstract();
    }

    /**
     * Check if given class is interface
     *
     * @param string $class
     *
     * @return bool
     *
     * @throws \ReflectionException
     */
    public function isInterface($class)
    {
        return (new \ReflectionClass($class))->isInterface();
    }

    /**
     * Check if given class is trait
     *
     * @param string $class
     *
     * @return bool
     *
     * @throws \ReflectionException
     */
    public function isTrait($class)
    {
        return (new \ReflectionClass($class))->isTrait();
    }
}