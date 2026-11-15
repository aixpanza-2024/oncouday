<?php
declare(strict_types=1);

final class TrialService
{
    public const PHASES   = ['I', 'II', 'III', 'IV'];
    public const STATUSES = ['recruiting' => 'Recruiting', 'not_yet_recruiting' => 'Not yet recruiting'];
    public const SOURCES  = ['doctor' => 'Doctors on OncoUday', 'ctgov' => 'ClinicalTrials.gov'];
    public const SORTS    = ['recent' => 'Recently updated', 'title' => 'Title (A–Z)', 'phase' => 'Phase (latest first)'];
    public const PER_PAGE = 10;

    public function __construct(
        private TrialRepositoryInterface $repo,
        private ContentService $content
    ) {
    }

    public function recent(int $limit = 3): array
    {
        return $this->repo->recent($limit);
    }

    public function filtersFromRequest(): array
    {
        $submitted = Request::has('f');

        $status = Request::queryList('status', array_keys(self::STATUSES));
        $source = Request::queryList('source', array_keys(self::SOURCES));

        return [
            'cancer' => Request::queryEnum('cancer', array_keys($this->content->cancerTypeMap()), ''),
            'city'   => Request::queryEnum('city', array_keys($this->content->cityMap()), ''),
            'q'      => Request::query('q', '', 80),
            'phases' => Request::queryList('phase', self::PHASES),
            'status' => ($submitted && $status) ? $status : array_keys(self::STATUSES),
            'source' => ($submitted && $source) ? $source : array_keys(self::SOURCES),
            'sort'   => Request::queryEnum('sort', array_keys(self::SORTS), 'recent'),
            'page'   => max(1, (int) Request::query('page', '1', 4)),
        ];
    }

    public function search(array $filters): array
    {
        $page   = $filters['page'] ?? 1;
        $total  = $this->repo->count($filters);
        $pages  = max(1, (int) ceil($total / self::PER_PAGE));
        $page   = min($page, $pages);
        $items  = $this->repo->search($filters, self::PER_PAGE, ($page - 1) * self::PER_PAGE);

        return ['items' => $items, 'total' => $total, 'page' => $page, 'pages' => $pages];
    }

    public static function statusLabel(string $status): string
    {
        return self::STATUSES[$status] ?? ucfirst(str_replace('_', ' ', $status));
    }
}
