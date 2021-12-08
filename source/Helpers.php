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

function sumInterval(DateInterval $interval1, DateInterval $interval2): DateInterval
{
    $date = new DateTime('00:00:00');

    $date->add($interval1);
    $date->add($interval2);

    return (new DateTime('00:00:00'))->diff($date);
}

function convertDateIntervalToDateTime(DateInterval $interval): DateTime
{
    return new DateTime($interval->format('%H:%i:%s'));
}

function setMessage(array $message, string $type = 'error'): void
{
    Message::set($message, $type);
}

function getMessage(string $key): ?string
{
    return Message::get($key);
}



