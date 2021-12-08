<?php


namespace Source\Classes;


use Exception;

class Message
{
    private static $types = [
        'success',
        'info',
        'error',
        'warning'
    ];

    public static function set(array $key_and_message, string $type = 'error'): void
    {
        foreach ($key_and_message as $key => $message) {

            if (!in_array($type, self::$types)) {

                throw new Exception('Informe um dos tipos disponiveis ' . implode(',', self::$types));
            }

            $_SESSION['message'][$key] = [
                'type' => $type,
                'message' => $message
            ];

        }
    }

    public static function get(string $key): ?string
    {
        if (isset($_SESSION['message'][$key]) && $message = $_SESSION['message'][$key]) {

            unset($_SESSION['message'][$key]);

            return "<div class=\"message_{$message['type']}\">{$message['message']}</div>";
        }

        return null;
    }
}