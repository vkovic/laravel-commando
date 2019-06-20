<?php

// TODO: put me in place

return [
    'database' => [
        'connection' => 'mysql', // See config/database.php
        'handlers' => [
            'sqlite' => null,
            'mysql' => \Vkovic\LaravelCommandos\Handlers\Database\MySql::class,
            'pgsql' => null,
            'sqlsrv' => null,
        ]
    ],
];