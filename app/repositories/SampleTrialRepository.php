<?php
declare(strict_types=1);

final class SampleTrialRepository implements TrialRepositoryInterface
{
    private array $trials;

    public function __construct()
    {
        $this->trials = array_map(static function (array $t): array {
            $city = content()->city($t['city_slug']);
            $t['state'] = $city['state'] ?? '';
            return $t;
        }, require APP_PATH . '/data/trials.php');
    }

    public function recent(int $limit): array
    {
        $rows = $this->trials;
        usort($rows, static fn ($a, $b) => strcmp($b['updated_at'], $a['updated_at']));
        return array_slice($rows, 0, $limit);
    }

    public function search(array $filters, int $limit, int $offset): array
    {
        return array_slice($this->filter($filters), $offset, $limit);
    }

    public function count(array $filters): int
    {
        return count($this->filter($filters));
    }

    private function filter(array $f): array
    {
        $q = mb_strtolower($f['q'] ?? '');

        $rows = array_filter($this->trials, static function (array $t) use ($f, $q): bool {
            if (!empty($f['cancer']) && $t['cancer_slug'] !== $f['cancer']) {
                return false;
            }
            if (!empty($f['state']) && $t['state'] !== $f['state']) {
                return false;
            }
            if (!empty($f['city']) && $t['city_slug'] !== $f['city']) {
                return false;
            }
            if (!empty($f['month']) && !str_starts_with((string) ($t['start_date'] ?? ''), $f['month'])) {
                return false;
            }
            if (!empty($f['phases']) && !in_array($t['phase'], $f['phases'], true)) {
                return false;
            }
            if (!empty($f['status']) && !in_array($t['status'], $f['status'], true)) {
                return false;
            }
            if (!empty($f['source']) && !in_array($t['source'], $f['source'], true)) {
                return false;
            }
            if ($q !== '') {
                $haystack = mb_strtolower($t['title'] . ' ' . $t['medicines'] . ' ' . $t['registry_id'] . ' ' . $t['cancer_type'] . ' ' . $t['hospital'] . ' ' . $t['city']);
                if (!str_contains($haystack, $q)) {
                    return false;
                }
            }
            return true;
        });

        $rows = array_values($rows);

        usort($rows, match ($f['sort'] ?? 'recent') {
            'title' => static fn ($a, $b) => strcasecmp($a['title'], $b['title']),
            'city'  => static fn ($a, $b) => strcasecmp($a['city'], $b['city']) ?: strcmp($b['updated_at'], $a['updated_at']),
            default => static fn ($a, $b) => strcmp($b['updated_at'], $a['updated_at']),
        });

        return $rows;
    }
}
