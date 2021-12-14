<?php


namespace Source\DataBase;


use PDO;
use PDOException;

abstract class DataBase
{
    public static function connection(): PDO
    {
        $db_config = (object) DATA_BASE_CONFIG;

        try {

            return new PDO(
                "{$db_config->adapter}:host={$db_config->host};dbname={$db_config->name}",
                $db_config->user,
                $db_config->pass,
                $db_config->options
            );
        } catch (PDOException $e) {

            die('Error: ' . $e->getMessage());
        }
    }
}