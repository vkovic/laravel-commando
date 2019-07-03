<?php

return [
    //
    // Database
    //

    'database' => [
        // Default app connection name.
        // By default we'll use the same connection as underlying Laravel project
        'connection' => env('DB_CONNECTION', 'mysql'),
        // Every db connection has its own driver name (see config/database.php).
        // By Laravel defaults, it can be: `sqlite`, `mysql`, `pgsql` and `sqlsrv`.
        // Here, we need to define which handler we want to use for which driver.
        'driver_handler' => [
            'mysql' => \Vkovic\LaravelCommando\Handlers\Database\MySqlHandler::class,
            'sqlite' => null,
            'pgsql' => null,
            'sqlsrv' => null,
        ]
    ],

    //
    // Console
    //

    'console' => [
        'system' => 'linux',
        'console_handler' => [
            'linux' => \Vkovic\LaravelCommando\Handlers\Console\LinuxHandler::class,
            'macos' => null,
            'windows' => null,
        ]
    ]
];