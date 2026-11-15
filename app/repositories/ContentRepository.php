<?php
declare(strict_types=1);

final class ContentRepository
{
    private array $data;

    public function __construct()
    {
        $this->data = require APP_PATH . '/data/content.php';
    }

    public function get(string $key): array
    {
        return $this->data[$key] ?? [];
    }
}
