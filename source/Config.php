<?php

date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_TIME,  'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

define('DAILY_TIME', 60 * 60 * 8);

define('PATHS', [
    'view' => __DIR__ . '/view'
]);

define('SITE', [
    'name' => 'Working Hours',
    'description' => 'Um sistema de bater ponto',
    'domain' => '',
    'locale' => 'pt_BR',
    'root' => 'http://localhost/working_hours/public'
]);



define('DATA_BASE_CONFIG',[
    'driver' => 'mysql',
    'host' => 'db',
    'port' => '3306',
    'dbname' => 'working_hours',
    'charset' => 'utf8',
    'username' => 'root',
    'password' => 'root',
    'options' => [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);