<?php


namespace Source\Classes;

class Message
{
    public static function check(string $key): bool
    {
        if (isset($_SESSION['message'][$key])) { return true; }

        return false;
    }

    public static function set(array $key_and_message, string $class = 'error'): void
    {
        foreach ($key_and_message as $key => $message) {

            $_SESSION['message'][$key] = [
                'class' => "message_{$class}",
                'message' => $message
            ];

        }
    }

    public static function get(string $key): ?string
    {
        if (isset($_SESSION['message'][$key]) && $message = $_SESSION['message'][$key]) {

            unset($_SESSION['message'][$key]);

            return "<div class=\"{$message['class']}\">{$message['message']}</div>";
        }

        return null;
    }
}