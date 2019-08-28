<?php

namespace Vkovic\LaravelCommando\Handlers\Database;

use PDO;

class MySqlHandler extends AbstractDbHandler
{
    /**
     * @var PDO
     */
    protected $pdo;

    /**
     * Raw database connection configuration.
     * See config/database.php for more info
     *
     * @var array
     */
    protected $config = [];

    public function __construct($config)
    {
        $this->config = $config;

        // TODO
        // User should be able to add more options to connection
        $this->pdo = $this->getPdo($config['host'], $config['port'], $config['username'], $config['password']);
    }

    public function databaseExists($database)
    {
        $stmt = $this->pdo->query("SELECT schema_name FROM information_schema.schemata WHERE schema_name = '$database'");

        return $stmt->fetch() !== false;
    }

    public function createDatabase($database)
    {
        $this->pdo->exec(sprintf(
            'CREATE DATABASE `%s` CHARACTER SET %s COLLATE %s;',
            $database,
            $this->config['charset'],
            $this->config['collation']
        ));
    }

    public function dropDatabase($database)
    {
        $this->pdo->exec("DROP DATABASE `$database`");
    }

    public function getColumns($database, $table)
    {
        $stmt = $this->pdo->query("SHOW COLUMNS FROM `$database`.`$table`");

        $data = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $i => $field) {
            // `name`, `position`, `type`, `nullable`, `default_value
            $data[] = [
                'name' => $field['Field'],
                'position' => $i,
                'type' => $field['Type'],
                'nullable' => $field['Null'] == 'YES',
                'default_value' => $field['Default']
            ];
        }

        return $data;
    }

    /**
     * Get PDO connection in case we want to perform custom queries
     *
     * @param $host
     * @param $port
     * @param $username
     * @param $password
     *
     * @return PDO
     */
    public function getPdo($host, $port, $username, $password)
    {
        if ($this->pdo === null) {
            $pdo = new PDO(sprintf('mysql:host=%s;port=%d;', $host, $port), $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->pdo = $pdo;
        }

        return $this->pdo;
    }
}