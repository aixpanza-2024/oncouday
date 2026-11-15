<?php
declare(strict_types=1);

final class Request
{
    public static function isPost(): bool
    {
        return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
    }

    public static function query(string $key, string $default = '', int $maxLength = 100): string
    {
        $value = $_GET[$key] ?? $default;
        if (!is_string($value)) {
            return $default;
        }
        $value = preg_replace('/[\x00-\x1F\x7F]/u', '', trim($value)) ?? '';
        return mb_substr($value, 0, $maxLength);
    }

    public static function queryEnum(string $key, array $allowed, ?string $default = null): ?string
    {
        $value = $_GET[$key] ?? null;
        return (is_string($value) && in_array($value, $allowed, true)) ? $value : $default;
    }

    public static function queryList(string $key, array $allowed): array
    {
        $value = $_GET[$key] ?? [];
        if (!is_array($value)) {
            $value = [$value];
        }
        $clean = [];
        foreach ($value as $item) {
            if (is_string($item) && in_array($item, $allowed, true)) {
                $clean[$item] = $item;
            }
        }
        return array_values($clean);
    }

    public static function has(string $key): bool
    {
        return isset($_GET[$key]);
    }
}
