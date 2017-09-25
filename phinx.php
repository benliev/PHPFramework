<?php

require 'public/index.php';

$migrations = [];
$seeds = [];

/** @var \Framework\Module[] $modules */
foreach ($modules as $module) {
    if ($module::getMigrations()) {
        $migrations[] = $module::getMigrations();
    }
    if ($module::getSeeds()) {
        $seeds[] = $module::getSeeds();
    }
}

$container = $app->getContainer();

return [
    'paths' => [
        'migrations' => $migrations,
        'seeds' => $seeds
    ],
    'environments' => [
        'default_database' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => $container->get('database.host'),
            'name' => $container->get('database.name'),
            'user' => $container->get('database.username'),
            'pass' => $container->get('database.password'),
        ],
    ],
];
