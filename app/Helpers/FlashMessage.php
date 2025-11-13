<?php

namespace App\Helpers;

class FlashMessage
{
    private const FLASH_KEY = 'flash_messages';

    /**
     * Add a success message.
     */
    public static function success(string $message): void
    {
        self::add('success', $message);
    }

    /**
     * Add an error message.
     */
    public static function error(string $message): void
    {
        self::add('error', $message);
    }

    /**
     * Add an info message.
     */
    public static function info(string $message): void
    {
        self::add('info', $message);
    }

    /**
     * Add a warning message.
     */
    public static function warning(string $message): void
    {
        self::add('warning', $message);
    }

    /**
     * Add a flash message of any type.
     */
    public static function add(string $type, string $message): void
    {
        if (!isset($_SESSION[self::FLASH_KEY])) {
            $_SESSION[self::FLASH_KEY] = [];
        }

        $_SESSION[self::FLASH_KEY][] = [
            'type' => $type,
            'message' => $message
        ];
    }

    /**
     * Get all flash messages and clear them.
     */
    public static function get(): array
    {
        $messages = $_SESSION[self::FLASH_KEY] ?? [];
        unset($_SESSION[self::FLASH_KEY]);
        return $messages;
    }

    /**
     * Check if there are any flash messages.
     */
    public static function has(): bool
    {
        return !empty($_SESSION[self::FLASH_KEY]);
    }

    /**
     * Clear all flash messages without retrieving them.
     */
    public static function clear(): void
    {
        unset($_SESSION[self::FLASH_KEY]);
    }

    /**
     * Render all flash messages as Bootstrap alerts.
     */
    public static function render(bool $dismissible = true): string
    {
        $messages = self::get();
        if (empty($messages)) {
            return '';
        }

        $bootstrapTypes = [
            'success' => 'success',
            'error' => 'danger',
            'info' => 'info',
            'warning' => 'warning'
        ];

        $html = '';
        foreach ($messages as $flash) {
            $type = $bootstrapTypes[$flash['type']] ?? 'info';
            $message = htmlspecialchars($flash['message']);

            if ($dismissible) {
                $html .= <<<HTML
                <div class="alert alert-{$type} alert-dismissible fade show" role="alert">
                    {$message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                HTML;
            } else {
                $html .= <<<HTML
                <div class="alert alert-{$type}" role="alert">
                    {$message}
                </div>
                HTML;
            }
        }

        return $html;
    }
}
