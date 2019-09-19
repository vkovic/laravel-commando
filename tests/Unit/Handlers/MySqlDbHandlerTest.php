<?php

namespace Vkovic\LaravelCommando\Test\Unit\Handlers;

use PDO;
use Str;
use Vkovic\LaravelCommando\Handlers\Database\MySqlHandler;
use Vkovic\LaravelCommando\Test\TestCase;

class MySqlDbHandlerTest extends TestCase
{
    /**
     * @var PDO
     */
    protected $pdo;

    /**
     * Database connection configuration
     *
     * @var
     */
    protected $config;

    public function setUp(): void
    {
        parent::setUp();

        // DB connection config
        $this->config = config('database.connections.mysql');

        // PDO
        $pdo = new PDO(sprintf('mysql:host=%s;port=%d;', $this->config['host'], $this->config['port']), $this->config['username'], $this->config['password']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo = $pdo;

        // Create default database if not exists
        $database = env('DB_DATABASE');
        $this->pdo->exec("CREATE DATABASE IF NOT EXISTS `$database`");
    }

    /**
     * @test
     */
    public function it_can_check_if_database_exists()
    {
        $dbHandler = new MySqlHandler($this->config);

        $this->assertTrue($dbHandler->databaseExists(env('DB_DATABASE')));
        $this->assertFalse($dbHandler->databaseExists('nonexistent_database'));
    }

    /**
     * @test
     */
    public function it_can_create_database()
    {
        // Database to create
        $database = 'new_database';

        $dbHandler = new MySqlHandler($this->config);
        $dbHandler->createDatabase($database);

        $stmt = $this->pdo->query("SELECT schema_name FROM information_schema.schemata WHERE schema_name = '$database'");
        $this->assertNotFalse($stmt->fetch());

        $this->pdo->exec("DROP DATABASE $database");
    }

    /**
     *
     */
    public function it_can_get_table_fields()
    {
        $database = env('DB_DATABASE');
        $table = '';
        $dbHandler = new MySqlHandler($this->config);

        $stmt = $this->pdo->query("SHOW COLUMNS FROM `$database`");
        $this->assertNotFalse($stmt->fetch());
    }
}