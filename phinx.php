<?php

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/source/DataBase/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/source/DataBase/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'production' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'production_db',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => DATA_BASE_CONFIG['driver'],
            'host' => DATA_BASE_CONFIG['host'],
            'name' => DATA_BASE_CONFIG['dbname'],
            'user' => DATA_BASE_CONFIG['username'],
            'pass' => DATA_BASE_CONFIG['password'],
            'port' => DATA_BASE_CONFIG['port'],
            'charset' => DATA_BASE_CONFIG['charset'],
        ],
        'testing' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'testing_db',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
