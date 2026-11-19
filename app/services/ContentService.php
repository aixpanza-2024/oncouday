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

    public function city(string $slug): ?array
    {
        foreach ($this->cities() as $c) {
            if ($c['slug'] === $slug) {
                return $c;
            }
        }
        return null;
    }

    public function states(): array
    {
        $states = array_values(array_unique(array_column($this->cities(), 'state')));
        sort($states);
        return $states;
    }

    public function citiesInState(string $state): array
    {
        if ($state === '') {
            return $this->cities();
        }
        return array_values(array_filter($this->cities(), static fn ($c) => $c['state'] === $state));
    }

    public function specialtyMap(): array
    {
        return array_column($this->specialties(), 'name', 'slug');
    }

    public function reviewedOn(string $page): ?string
    {
        return $this->reviewed()[$page] ?? null;
    }
}
