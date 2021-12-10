<?php

use Source\Classes\Message;

function asset(string $path): string
{
    return SITE['root'] . "/asset/{$path}";
}

function url(string $path): string
{
    return SITE['root'] . "/{$path}";
}

function setMessage(array $message, string $type = 'error'): void
{
    Message::set($message, $type);
}

function getMessage(string $key): ?string
{
    return Message::get($key);
}



