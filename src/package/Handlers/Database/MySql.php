<?php

// TODO styling of comment and some more text

//
// Part of the file
//

// return [
//
//     /*
//     |--------------------------------------------------------------------------
//     | Default Database Connection Name
//     |--------------------------------------------------------------------------
//     |
//     | Here you may specify which of the database connections below you wish
//     | to use as your default connection for all database work. Of course
//     | you may use many connections at once using the Database library.
//     |
//     */
//
//     'default' => env('DB_CONNECTION', 'mysql'),
//
//     /*
//     |--------------------------------------------------------------------------
//     | Database Connections
//     |--------------------------------------------------------------------------
//     |
//     | Here are each of the database connections setup for your application.
//     | Of course, examples of configuring each database platform that is
//     | supported by Laravel is shown below to make development simple.
//     |
//     |
//     | All database work in Laravel is done through the PHP PDO facilities
//     | so make sure you have the driver for your particular database of
//     | choice installed on your machine before you begin development.
//     |
//     */
//
//     'connections' => [
//
//         'testing' => [
//             'driver' => 'sqlite',
//             'database' => ':memory:',
//             'foreign_key_constraints' => env('DB_FOREIGN_KEYS', false),
//         ],
//
//         'sqlite' => [
//             'driver' => 'sqlite',
//             'url' => env('DATABASE_URL'),
//             'database' => env('DB_DATABASE', database_path('database.sqlite')),
//             'prefix' => '',
//             'foreign_key_constraints' => env('DB_FOREIGN_KEYS', false),
//         ],
//
//         'mysql' => [
//             'driver' => 'mysql',
//             'url' => env('DATABASE_URL'),
//             'host' => env('DB_HOST', '127.0.0.1'),
//             'port' => env('DB_PORT', '3306'),
//             'database' => env('DB_DATABASE', 'forge'),
//             'username' => env('DB_USERNAME', 'forge'),
//             'password' => env('DB_PASSWORD', ''),
//             'unix_socket' => env('DB_SOCKET', ''),
//             'charset' => 'utf8mb4',
//             'collation' => 'utf8mb4_unicode_ci',
//             'prefix' => '',
//             'prefix_indexes' => true,
//             'strict' => true,
//             'engine' => null,
//             'options' => extension_loaded('pdo_mysql') ? array_filter([
//                 PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
//             ]) : [],
//         ],
//
//         'pgsql' => [
//             'driver' => 'pgsql',
//             'url' => env('DATABASE_URL'),
//             'host' => env('DB_HOST', '127.0.0.1'),
//             'port' => env('DB_PORT', '5432'),
//             'database' => env('DB_DATABASE', 'forge'),
//             'username' => env('DB_USERNAME', 'forge'),
//             'password' => env('DB_PASSWORD', ''),
//             'charset' => 'utf8',
//             'prefix' => '',
//             'prefix_indexes' => true,
//             'schema' => 'public',
//             'sslmode' => 'prefer',
//         ],
//
//         'sqlsrv' => [
//             'driver' => 'sqlsrv',
//             'url' => env('DATABASE_URL'),
//             'host' => env('DB_HOST', 'localhost'),
//             'port' => env('DB_PORT', '1433'),
//             'database' => env('DB_DATABASE', 'forge'),
//             'username' => env('DB_USERNAME', 'forge'),
//             'password' => env('DB_PASSWORD', ''),
//             'charset' => 'utf8',
//             'prefix' => '',
//             'prefix_indexes' => true,
//         ],
//
//     ],

namespace Vkovic\LaravelCommandos\Handlers\Database;

use PDO;
use Vkovic\LaravelCommandos\Handlers\Database\Exceptions\AbstractDbException;
use Vkovic\LaravelCommandos\Handlers\Database\Exceptions\DbCreateException;
use Vkovic\LaravelCommandos\Handlers\Database\Exceptions\DbDropException;
use Vkovic\LaravelCommandos\Handlers\Database\Exceptions\DbExistCheckException;

class MySql extends AbstractDbException
{
    /**
     * @var PDO
     */
    protected $pdo;

    public function __construct($config)
    {
        // TODO
        // User should be able to add more options to connection
        $this->pdo = $this->getPdo($config['host'], $config['port'], $config['username'], $config['password']);
    }

    public function databaseExists($database): bool
    {
        try {
            $stmt = $this->pdo->query("SELECT schema_name FROM information_schema.schemata WHERE schema_name = '$database'");
        } catch (\Exception $e) {
            throw new DbExistCheckException($e->getMessage());
        }

        return $stmt->fetch() !== false;
    }

    public function createDatabase($database): void
    {
        try {
            $stmt = $this->pdo->query("CREATE DATABASE '$database'");
        } catch (\Exception $e) {
            throw new DbCreateException($e->getMessage());
        }

        $stmt->execute();
    }

    public function dropDatabase($database): void
    {
        try {
            $stmt = $this->pdo->query("DROP DATABASE '$database'");
        } catch (\Exception $e) {
            throw new DbDropException($e->getMessage());
        }

        $stmt->execute();
    }

    protected function getPdo($host, $port, $username, $password): PDO
    {
        if ($this->pdo === null) {
            $pdo = new PDO(sprintf('mysql:host=%s;port=%d;', $host, $port), $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->pdo = $pdo;
        }

        return $this->pdo;
    }
}