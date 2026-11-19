<?php
declare(strict_types=1);
require __DIR__ . '/app/bootstrap.php';

$page = [
    'title'       => 'Explore Clinical Trials',
    'active'      => 'explore',
    'description' => 'Search active cancer clinical trials across India by cancer type, state, city, medicine and recruitment month. Data refreshed daily, with real-time updates from researchers and trial teams.',
];

$filters = trials()->filtersFromRequest();
$result  = trials()->search($filters);

$filterUrl = static function (array $changes) use ($filters): string {
    $query = [
        'f'      => 1,
        'cancer' => $filters['cancer'],
        'state'  => $filters['state'],
        'city'   => $filters['city'],
        'month'  => $filters['month'],
        'q'      => $filters['q'],
        'phase'  => $filters['phases'],
        'status' => $filters['status'],
        'source' => $filters['source'],
        'sort'   => $filters['sort'],
        'per'    => $filters['per'] === TrialService::PER_PAGE ? null : $filters['per'],
    ];
    $query = array_filter(array_merge($query, $changes), static fn ($v) => $v !== '' && $v !== [] && $v !== null);
    return url('explore-trials.php', $query);
};

$without = static function (string $key, ?string $value = null) use ($filters, $filterUrl): string {
    $list = ['phase' => 'phases', 'status' => 'status', 'source' => 'source'];
    if (isset($list[$key])) {
        return $filterUrl([$key => array_values(array_diff($filters[$list[$key]], [$value])), 'page' => null]);
    }
    $changes = [$key => '', 'page' => null];
    if ($key === 'state') {
        $changes['city'] = '';
    }
    return $filterUrl($changes);
};

$hiddenFilters = static function (array $skip) use ($filters): string {
    $html = '<input type="hidden" name="f" value="1">';
    $single = ['cancer' => $filters['cancer'], 'state' => $filters['state'], 'city' => $filters['city'], 'month' => $filters['month'], 'q' => $filters['q'], 'sort' => $filters['sort'], 'per' => $filters['per'] === TrialService::PER_PAGE ? '' : (string) $filters['per']];
    foreach ($single as $k => $v) {
        if ($v !== '' && !in_array($k, $skip, true)) {
            $html .= '<input type="hidden" name="' . e($k) . '" value="' . e($v) . '">';
        }
    }
    foreach (['phase' => $filters['phases'], 'status' => $filters['status'], 'source' => $filters['source']] as $k => $list) {
        foreach ($list as $v) {
            $html .= '<input type="hidden" name="' . e($k) . '[]" value="' . e($v) . '">';
        }
    }
    return $html;
};

$cityNames  = content()->cityMap();
$monthNames = TrialService::monthOptions();
$active = [];
if ($filters['q'] !== '') {
    $active[] = ['“' . $filters['q'] . '”', $without('q')];
}
if ($filters['cancer'] !== '') {
    $active[] = [content()->cancerTypeMap()[$filters['cancer']] ?? $filters['cancer'], $without('cancer')];
}
if ($filters['state'] !== '') {
    $active[] = [$filters['state'], $without('state')];
}
if ($filters['city'] !== '') {
    $active[] = [$cityNames[$filters['city']] ?? $filters['city'], $without('city')];
}
if ($filters['month'] !== '') {
    $active[] = ['Starts ' . ($monthNames[$filters['month']] ?? $filters['month']), $without('month')];
}
foreach ($filters['phases'] as $p) {
    $active[] = ['Phase ' . $p, $without('phase', $p)];
}
foreach ($filters['status'] as $s) {
    $active[] = [TrialService::statusLabel($s), $without('status', $s)];
}
foreach ($filters['source'] as $s) {
    $active[] = [$s === 'doctor' ? 'Verified by doctors' : 'ClinicalTrials.gov', $without('source', $s)];
}

require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <h1 class="page-title" data-aos="fade-up">Explore clinical trials</h1>
                <p class="lead-ou" data-aos="fade-up" data-aos-delay="100">Active cancer trials across India. Data refreshed daily, with real-time updates directly from researchers and trial teams. Search by cancer type, state, city, medicine or recruitment month.</p>
                <div class="chip-row chip-row--single" data-aos="fade-up" data-aos-delay="200">
                    <a class="chip<?= $filters['cancer'] === '' ? ' active' : '' ?>" href="<?= e($filterUrl(['cancer' => '', 'page' => null])) ?>">All cancers</a>
                    <?php foreach (content()->cancerTypes() as $c): if (!$c['featured']) continue; ?>
                        <a class="chip<?= $filters['cancer'] === $c['slug'] ? ' active' : '' ?>" href="<?= e($filterUrl(['cancer' => $c['slug']])) ?>"><?= e($c['chip']) ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-lg-4 d-flex justify-content-center justify-content-lg-end">
                <?php illustration('radar'); ?>
            </div>
        </div>
        <?php partial('reviewed', ['key' => 'explore', 'delay' => 250]); ?>
    </div>
</section>

<section class="section section--explore" id="results">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3">
                <button class="btn btn-outline-navy w-100 d-lg-none mb-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterPanel" aria-controls="filterPanel">
                    <i class="bi bi-sliders me-1" aria-hidden="true"></i> Filter trials
                </button>
                <div class="offcanvas-lg offcanvas-start filter-panel" tabindex="-1" id="filterPanel" aria-labelledby="filterPanelTitle">
                    <div class="offcanvas-header">
                        <h2 class="h5 mb-0" id="filterPanelTitle">Filter trials</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#filterPanel" aria-label="Close filters"></button>
                    </div>
                    <div class="offcanvas-body">
                        <form class="filter-form js-filter-form" action="<?= e(url('explore-trials.php')) ?>" method="get" data-aos="fade-right">
                            <h2 class="filter-title d-none d-lg-block">Filter trials</h2>
                            <input type="hidden" name="f" value="1">
                            <input type="hidden" name="sort" value="<?= e($filters['sort']) ?>">
                            <?php if ($filters['q'] !== ''): ?><input type="hidden" name="q" value="<?= e($filters['q']) ?>"><?php endif; ?>
                            <?php if ($filters['month'] !== ''): ?><input type="hidden" name="month" value="<?= e($filters['month']) ?>"><?php endif; ?>
                            <?php if ($filters['per'] !== TrialService::PER_PAGE): ?><input type="hidden" name="per" value="<?= (int) $filters['per'] ?>"><?php endif; ?>

                            <div class="mb-3">
                                <label class="form-label" for="fcancer">Cancer type</label>
                                <select class="form-select" id="fcancer" name="cancer">
                                    <option value="">All cancer types</option>
                                    <?php foreach (content()->cancerTypes() as $c): ?>
                                        <option value="<?= e($c['slug']) ?>"<?= $filters['cancer'] === $c['slug'] ? ' selected' : '' ?>><?= e($c['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?php partial('state-city', ['mode' => 'filter', 'prefix' => 'f', 'wrap' => 'mb-3', 'state' => $filters['state'], 'city' => $filters['city']]); ?>

                            <fieldset class="mb-3">
                                <legend>Phase</legend>
                                <?php foreach (TrialService::PHASES as $p): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="phase[]" id="ph<?= e($p) ?>" value="<?= e($p) ?>"<?= in_array($p, $filters['phases'], true) ? ' checked' : '' ?>>
                                        <label class="form-check-label" for="ph<?= e($p) ?>">Phase <?= e($p) ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </fieldset>

                            <fieldset class="mb-3">
                                <legend>Status</legend>
                                <?php foreach (TrialService::STATUSES as $key => $label): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="status[]" id="st-<?= e($key) ?>" value="<?= e($key) ?>"<?= in_array($key, $filters['status'], true) ? ' checked' : '' ?>>
                                        <label class="form-check-label" for="st-<?= e($key) ?>"><?= e($label) ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </fieldset>

                            <fieldset class="mb-4">
                                <legend>Listed by</legend>
                                <?php foreach (TrialService::SOURCES as $key => $label): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="source[]" id="so-<?= e($key) ?>" value="<?= e($key) ?>"<?= in_array($key, $filters['source'], true) ? ' checked' : '' ?>>
                                        <label class="form-check-label" for="so-<?= e($key) ?>"><?= e($label) ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </fieldset>

                            <noscript><button class="btn btn-navy w-100 mb-2" type="submit">Apply filters</button></noscript>
                            <a class="btn btn-outline-navy w-100" href="<?= e(url('explore-trials.php')) ?>">Clear filters</a>

                            <div class="alert-box mt-4">
                                <i class="bi bi-whatsapp" aria-hidden="true"></i>
                                <p class="mb-2"><strong>Get WhatsApp alerts for new trials</strong><br>Register your city and cancer type, and we'll tell you when a matching trial opens.</p>
                                <a class="btn btn-magenta btn-sm w-100" href="<?= e(url('patient-registration.php')) ?>">Get trial alerts</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <form class="explore-search" action="<?= e(url('explore-trials.php')) ?>#results" method="get" role="search" data-aos="fade-up">
                    <?= $hiddenFilters(['q', 'month']) ?>
                    <div class="explore-search__field">
                        <label class="visually-hidden" for="fq">Search trials</label>
                        <i class="bi bi-search explore-search__icon" aria-hidden="true"></i>
                        <input class="form-control" type="search" id="fq" name="q" maxlength="80" value="<?= e($filters['q']) ?>" placeholder="Search by medicine, keyword, hospital or trial ID…" autocomplete="off">
                    </div>
                    <label class="visually-hidden" for="fmonth">Recruitment start month</label>
                    <select class="form-select explore-search__month" id="fmonth" name="month">
                        <option value="">Any start month</option>
                        <?php foreach (TrialService::monthOptions() as $val => $label): ?>
                            <option value="<?= e($val) ?>"<?= $filters['month'] === $val ? ' selected' : '' ?>><?= e($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button class="btn btn-navy" type="submit" aria-label="Search"><i class="bi bi-search" aria-hidden="true"></i><span class="d-none d-sm-inline ms-2">Search</span></button>
                </form>

                <?php if ($active): ?>
                    <div class="active-filters" aria-label="Active filters">
                        <?php foreach ($active as [$label, $href]): ?>
                            <a class="filter-pill" href="<?= e($href) ?>#results" aria-label="Remove filter: <?= e($label) ?>"><?= e($label) ?> <i class="bi bi-x-circle-fill" aria-hidden="true"></i></a>
                        <?php endforeach; ?>
                        <a class="filter-pill-clear" href="<?= e(url('explore-trials.php')) ?>#results">Clear all</a>
                    </div>
                <?php endif; ?>

                <div class="results-bar" data-aos="fade-up">
                    <p class="mb-0" role="status">
                        <strong><?= (int) $result['total'] ?></strong> trial<?= $result['total'] === 1 ? '' : 's' ?> found<?php if ($result['total'] > 0): ?><span class="text-muted-ou"> · showing <?= (int) $result['from'] ?> to <?= (int) $result['to'] ?></span><?php endif; ?>
                    </p>
                    <div class="results-tools">
                        <nav class="per-page" aria-label="Trials per page">
                            <span class="small text-muted-ou">Show</span>
                            <?php foreach (TrialService::PER_PAGE_OPTIONS as $n): ?>
                                <a href="<?= e($filterUrl(['per' => $n === TrialService::PER_PAGE ? null : $n, 'page' => null])) ?>#results"<?= $result['per'] === $n ? ' class="active" aria-current="true"' : '' ?>><?= $n ?></a>
                            <?php endforeach; ?>
                            <span class="small text-muted-ou">per page</span>
                        </nav>
                    <form class="d-flex align-items-center gap-2 js-sort-form" action="<?= e(url('explore-trials.php')) ?>" method="get">
                        <?= $hiddenFilters(['sort']) ?>
                        <label class="small text-muted-ou text-nowrap" for="sort">Sort by</label>
                        <select class="form-select form-select-sm" id="sort" name="sort">
                            <?php foreach (TrialService::SORTS as $key => $label): ?>
                                <option value="<?= e($key) ?>"<?= $filters['sort'] === $key ? ' selected' : '' ?>><?= e($label) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                    </div>
                </div>

                <?php if (!$result['items']): ?>
                    <div class="empty-state" data-aos="zoom-in">
                        <i class="bi bi-search-heart" aria-hidden="true"></i>
                        <h2 class="h5">No trials match these filters yet</h2>
                        <p>Try fewer filters, or register and we'll tell you on WhatsApp when a matching trial opens.</p>
                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                            <a class="btn btn-outline-navy" href="<?= e(url('explore-trials.php')) ?>">Clear filters</a>
                            <a class="btn btn-magenta" href="<?= e(url('patient-registration.php')) ?>">Get trial alerts</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="d-grid gap-3">
                        <?php foreach ($result['items'] as $i => $trial): ?>
                            <?php partial('trial-card', ['trial' => $trial, 'variant' => 'full', 'delay' => min($i, 4) * 60, 'number' => $result['from'] + $i]); ?>
                        <?php endforeach; ?>
                    </div>

                    <?php if ($result['pages'] > 1): ?>
                        <nav class="mt-4" aria-label="Trial pages">
                            <ul class="pagination ou-pagination justify-content-center">
                                <?php for ($p = 1; $p <= $result['pages']; $p++): ?>
                                    <li class="page-item<?= $p === $result['page'] ? ' active' : '' ?>">
                                        <a class="page-link" href="<?= e($filterUrl(['page' => $p])) ?>"<?= $p === $result['page'] ? ' aria-current="page"' : '' ?>><?= $p ?></a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                <?php endif; ?>

                <p class="small-note mt-4 mb-0"><i class="bi bi-info-circle me-1" aria-hidden="true"></i>
                    OncoUday shares trial information only and does not give medical advice. Some listings come from ClinicalTrials.gov, a service of the U.S. National Library of Medicine, and are labelled with their source.
                    <a href="<?= e(url('medical-disclaimer.php')) ?>">Medical disclaimer</a></p>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
