<?php

return [
    'database' => [
        // Default app connection name.
        // By default we'll use the same connection as underlying Laravel project
        'connection' => env('DB_CONNECTION', 'mysql'),
        // Every db connection has its own driver name (see config/database.php).
        // By Laravel defaults, it can be: `sqlite`, `mysql`, `pgsql` and `sqlsrv`.
        // Here, we need to define which handler we want to use for which driver.
        'driver_handler' => [
            'sqlite' => null,
            'mysql' => \Vkovic\LaravelCommandos\Handlers\Database\MySql::class,
            'pgsql' => null,
            'sqlsrv' => null,
        ]
    ],
];