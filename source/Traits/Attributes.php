<?php

namespace Source\Traits;

trait Attributes
{
    protected $attributes;

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function __get($key)
    {
        return $this->attributes[$key];
    }

    public function __set($key, $value): void
    {
        $this->attributes[$key] = $value;
    }

    public function __unset($key): void
    {
        unset($this->attributes[$key]);
    }

    public function __isset($key): bool
    {
        return isset($this->attributes[$key]);
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
