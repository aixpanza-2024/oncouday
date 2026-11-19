<?php
declare(strict_types=1);

final class TrialService
{
    public const PHASES   = ['I', 'II', 'III', 'IV'];
    public const STATUSES = ['recruiting' => 'Recruiting', 'not_yet_recruiting' => 'Not yet recruiting'];
    public const SOURCES  = ['doctor' => 'Doctors on OncoUday (verified)', 'ctgov' => 'ClinicalTrials.gov'];
    public const SORTS    = ['recent' => 'Recently updated', 'title' => 'Title (A–Z)', 'city' => 'City (A–Z)'];
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
        $state = Request::queryEnum('state', $this->content->states(), '');
        $city  = Request::queryEnum('city', array_column($this->content->citiesInState($state), 'slug'), '');
        $month = Request::query('month', '', 7);
        $month = preg_match('/^20\d{2}-(0[1-9]|1[0-2])$/', $month) ? $month : '';

        $filters = [
            'cancer' => Request::queryEnum('cancer', array_keys($this->content->cancerTypeMap()), ''),
            'state'  => $state,
            'city'   => $city,
            'month'  => $month,
            'q'      => Request::query('q', '', 80),
            'phases' => Request::queryList('phase', self::PHASES),
            'status' => Request::queryList('status', array_keys(self::STATUSES)),
            'source' => Request::queryList('source', array_keys(self::SOURCES)),
            'sort'   => Request::queryEnum('sort', array_keys(self::SORTS), 'recent'),
            'page'   => max(1, (int) Request::query('page', '1', 4)),
        ];

        return $filters;
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

    public static function monthOptions(): array
    {
        $options = [];
        $start = new DateTimeImmutable('first day of this month');
        for ($i = -6; $i <= 12; $i++) {
            $m = $start->modify(($i >= 0 ? '+' : '') . $i . ' months');
            $options[$m->format('Y-m')] = $m->format('F Y');
        }
        return $options;
    }

    public static function statusLabel(string $status): string
    {
        return self::STATUSES[$status] ?? ucfirst(str_replace('_', ' ', $status));
    }
}
