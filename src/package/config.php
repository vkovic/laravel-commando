<?php


// TODO: put me in place

return [
    // Checkout interface:
    // `Vkovic\LaravelCommandos\DatabaseCommands\DatabaseCommandsInterface`
    'database_commands' => [
        'sqlite' => null,
        'mysql' => \Vkovic\LaravelCommandos\Handlers\Database\MySql::class,
        'pgsql' => null,
        'sqlsrv' => null,
    ]
];