<?php


namespace Source\Exception;


use Throwable;

class ValidationException extends AppException
{
    protected $errors;

    public function __construct(array $errors, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->errors = $errors;

        parent::__construct($message, $code, $previous);
    }

    public function __get($key)
    {
        return $this->errors[$key];
    }

    public function __set($key, $value): void
    {
        $this->errors[$key] = $value;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}