<?php
declare(strict_types=1);

final class ContentService
{
    private array $cache = [];

    public function __construct(private ContentRepository $repo)
    {
    }

    public function __call(string $name, array $args): array
    {
        return $this->cache[$name] ??= $this->repo->get($name);
    }

    public function cancerTypeMap(): array
    {
        return array_column($this->cancerTypes(), 'name', 'slug');
    }

    public function cityMap(): array
    {
        return array_column($this->cities(), 'name', 'slug');
    }

    public function specialtyMap(): array
    {
        return array_column($this->specialties(), 'name', 'slug');
    }
}
