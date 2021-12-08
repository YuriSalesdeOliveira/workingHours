<?php

namespace Source\Model;

use PDO;
use Exception;
use Source\DataBase\DataBase;
use Source\Traits\Attributes;

abstract class Model extends DataBase
{
    use Attributes;

    protected static $entity;
    protected static $columns;

    public static function delete(array $filter): bool
    {
        $sql = 'DELETE FROM ' . static::$entity . self::placeholder('WHERE', $filter);

        $connection = self::connection();

        $stmt = $connection->prepare($sql);

        if ($stmt->execute($filter)) {

            return true;
        }

        return false;
    }

    public function save(): bool
    {
        $this->checkRequiredColumns();

        $primary = static::$columns['primary'];

        if (isset($this->$primary)) {

            return $this->update();
        }

        return $this->insert();
    }

    protected function checkRequiredColumns()
    {
        if (!empty($required_columns = static::$columns['require'])) {

            foreach ($required_columns as $column) {

                if (!in_array($column, array_keys($this->attributes))) {

                    throw new Exception('O objeto deve conter todos os atributos obrigatórios');
                }
            }
        }
    }

    protected function insert(): bool
    {
        if (static::$columns['timestamps']) {

            $this->created_at = date('Y-m-d H:i:s');
        }

        $sql = 'INSERT INTO ' . static::$entity . ' (' . implode(',', array_keys($this->attributes)) . ') VALUES ('
            . ':' . implode(', :', array_keys($this->attributes)) . ')';

        $connection = self::connection();

        $stmt = $connection->prepare($sql);

        if ($stmt->execute($this->attributes)) {

            return true;
        }

        return false;
    }

    protected function update(): bool
    {
        if (static::$columns['timestamps']) {

            $this->updated_at = date('Y-m-d H:i:s');
        }

        $primary = static::$columns['primary'];

        $attributes = $this->attributes;

        unset($attributes[$primary]);

        $sql = 'UPDATE ' . static::$entity . self::placeholder('SET', $attributes)
            . self::placeholder('WHERE', [$primary => $this->$primary]);

        $connection = self::connection();

        $stmt = $connection->prepare($sql);

        if ($stmt->execute($this->attributes)) {

            return true;
        }

        return false;
    }

    public static function find(array $filters = [], string $columns = '*')
    {
        $stmt = self::getResultFromSelect($filters, $columns);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $class = get_called_class();

        if (count($rows) > 1) {

            foreach ($rows as $row) {

                $objects[] = new $class($row);
            }

            return $objects;
        }

        return $rows ? new $class($rows[0]) : null;
    }

    protected static function getResultFromSelect(array $filters = [], string $columns = '*'): object
    {
        $sql = "SELECT {$columns} FROM " . static::$entity . self::placeholder('WHERE', $filters);

        $connection = self::connection();

        $stmt = $connection->prepare($sql);

        $stmt->execute($filters);

        return $stmt;
    }

    protected static function placeholder(string $type, array $filters): string
    {
        switch ($type) {

            case 'WHERE':

                $sql = ' WHERE 1 = 1 ';

                foreach (array_keys($filters) as $key) {

                    $sql .= " AND {$key} = :{$key}";
                }

                break;

            case 'SET':

                $sql = ' SET ';

                foreach (array_keys($filters) as $key) {

                    $sql .= "{$key} = :{$key},";
                }

                $sql = substr($sql, 0, -1);

                break;
        }

        return $sql;
    }
}
