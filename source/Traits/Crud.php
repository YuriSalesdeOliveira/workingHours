<?php


namespace Source\Traits;


trait Crud
{
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

    protected function insert(): bool
    {
        $sql = 'INSERT INTO ' . static::$entity . ' (' . implode(',', array_keys($this->attributes)) . ') VALUES ('
            . ':' . implode(', :', array_keys($this->attributes)) . ')';

        $connection = self::connection();

        $stmt = $connection->prepare($sql);

        if ($stmt->execute($this->attributes)) {

            return true;
        }

        return false;
    }

}