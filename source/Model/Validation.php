<?php

namespace Source\Model;

use Source\Exception\ValidationException;

class Validation extends Model
{
    private $errors;

    public function require(array $attributes = []): Validation
    {
        if ($attributes) {

            foreach ($attributes as $key) {

                if (empty($this->$key)) {

                    $this->setError($key, 'Esse campo é obrigatório.');
                }
            }

            return $this;
        }

        foreach ($this->attributes as $key => $value) {

            if (empty($value)) {

                $this->setError($key, 'Esse campo é obrigatório.');
            }
        }

        return $this;
    }

    public function unique(array $attributes): Validation
    {
        $primary = static::$columns['primary'];

        foreach ($attributes as $key => $class) {

            if (isset($this->$primary)) {

                $result = $class::find([$primary => $this->$primary]);

                if ($result && $result->$key === $this->$key) return $this;

            }

            $result = $class::find([$key => $this->$key]);

            if ($result) {

                $this->setError($key, 'O valor digitado já está cadastrado.');
            }
        }

        return $this;
    }

    public function isEmail(array $attributes): Validation
    {
        foreach ($attributes as $key) {

            if (!filter_var($this->$key, FILTER_VALIDATE_EMAIL)) {

                $this->setError($key, 'O valor digitado não é um email válido.');
            }
        }

        return $this;
    }

    public function max(array $attributes): Validation
    {
        foreach ($attributes as $key => $max) {

            if (strlen($this->$key) > $max) {

                $this->setError($key, "Esse campo deve conter no máximo {$max} caracteres.");
            }
        }

        return $this;
    }

    public function min(array $attributes): Validation
    {
        foreach ($attributes as $key => $min) {

            if (strlen($this->$key) < $min) {

                $this->setError($key, "Esse campo deve conter no mínimo {$min} caracteres.");
            }
        }

        return $this;
    }

    public function imageType(array $attributes): Validation
    {
        return $this;
    }

    protected function setError($key, $message)
    {
        $this->errors[$key] = $message;
    }

    public function throwErrors(): void
    {
        if ($this->errors) {

            throw new ValidationException($this->errors);
        }
    }
}
