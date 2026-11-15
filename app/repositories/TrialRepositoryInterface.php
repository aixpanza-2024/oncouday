<?php
declare(strict_types=1);

interface TrialRepositoryInterface
{
    public function recent(int $limit): array;

    public function search(array $filters, int $limit, int $offset): array;

    public function count(array $filters): int;
}
