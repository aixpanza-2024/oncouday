<?php
declare(strict_types=1);

final class MysqlTrialRepository implements TrialRepositoryInterface
{
    private const SELECT = <<<SQL
        SELECT t.public_id, t.registry_id, t.title, t.phase, t.status, t.source,
               t.medicines_text AS medicines, t.updated_at, t.start_date,
               COALESCE(t.last_confirmed_at, t.ctgov_synced_at, t.updated_at) AS last_confirmed,
               ct.name AS cancer_type, ct.slug AS cancer_slug,
               c.name  AS city, c.slug AS city_slug, c.state,
               h.name  AS hospital,
               d.full_name AS doctor_name
          FROM trials t
          JOIN cancer_types ct ON ct.id = t.cancer_type_id
          JOIN cities c        ON c.id  = t.city_id
          LEFT JOIN hospitals h ON h.id = t.hospital_id
          LEFT JOIN doctors d   ON d.id = t.added_by_doctor_id
        SQL;

    private const OPEN = "t.status IN ('recruiting','not_yet_recruiting')";

    private const SORTS = [
        'recent' => 't.updated_at DESC, t.id DESC',
        'title'  => 't.title ASC',
        'city'   => 'c.name ASC, t.updated_at DESC',
    ];

    public function recent(int $limit): array
    {
        $sql = self::SELECT . '
         WHERE t.is_published = 1 AND ' . self::OPEN . '
         ORDER BY t.updated_at DESC
         LIMIT :limit';

        return array_map([$this, 'map'], Database::fetchAll($sql, ['limit' => max(1, $limit)]));
    }

    public function search(array $filters, int $limit, int $offset): array
    {
        [$where, $params] = $this->buildWhere($filters);

        $order = self::SORTS[$filters['sort'] ?? 'recent'] ?? self::SORTS['recent'];

        $sql = self::SELECT . " WHERE {$where} ORDER BY {$order} LIMIT :limit OFFSET :offset";
        $params['limit']  = max(1, min($limit, 100));
        $params['offset'] = max(0, $offset);

        return array_map([$this, 'map'], Database::fetchAll($sql, $params));
    }

    public function count(array $filters): int
    {
        [$where, $params] = $this->buildWhere($filters);
        $sql = "SELECT COUNT(*)
                  FROM trials t
                  JOIN cancer_types ct ON ct.id = t.cancer_type_id
                  JOIN cities c        ON c.id  = t.city_id
                 WHERE {$where}";
        return (int) Database::fetchValue($sql, $params);
    }

    private function buildWhere(array $f): array
    {
        $where  = ['t.is_published = 1'];
        $params = [];

        if (!empty($f['cancer'])) {
            $where[] = 'ct.slug = :cancer';
            $params['cancer'] = $f['cancer'];
        }
        if (!empty($f['state'])) {
            $where[] = 'c.state = :state';
            $params['state'] = $f['state'];
        }
        if (!empty($f['city'])) {
            $where[] = 'c.slug = :city';
            $params['city'] = $f['city'];
        }
        if (!empty($f['month'])) {
            $from = $f['month'] . '-01';
            $where[] = 't.start_date >= :mfrom AND t.start_date < :mto';
            $params['mfrom'] = $from;
            $params['mto']   = date('Y-m-d', strtotime($from . ' +1 month'));
        }
        if (empty($f['status'])) {
            $where[] = self::OPEN;
        }

        foreach (['phases' => 't.phase', 'status' => 't.status', 'source' => 't.source'] as $key => $column) {
            if (!empty($f[$key])) {
                $holders = [];
                foreach (array_values($f[$key]) as $i => $value) {
                    $name = $key . $i;
                    $holders[] = ':' . $name;
                    $params[$name] = $value;
                }
                $where[] = $column . ' IN (' . implode(',', $holders) . ')';
            }
        }

        $q = trim($f['q'] ?? '');
        if ($q !== '') {
            $terms = $this->fulltextTerms($q);
            if ($terms !== '') {
                $where[] = '(MATCH(t.title, t.medicines_text) AGAINST (:ft IN BOOLEAN MODE) OR t.registry_id = :rid)';
                $params['ft']  = $terms;
                $params['rid'] = $q;
            } else {
                $where[] = "(t.title LIKE :like ESCAPE '\\\\' OR t.medicines_text LIKE :like2 ESCAPE '\\\\')";
                $like = '%' . addcslashes($q, '%_\\') . '%';
                $params['like']  = $like;
                $params['like2'] = $like;
            }
        }

        return [implode(' AND ', $where), $params];
    }

    private function fulltextTerms(string $q): string
    {
        $clean = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $q) ?? '';
        $words = array_filter(preg_split('/\s+/', $clean) ?: [], static fn ($w) => mb_strlen($w) >= 3);
        return implode(' ', array_map(static fn ($w) => '+' . $w . '*', array_slice($words, 0, 8)));
    }

    private function map(array $row): array
    {
        $row['phase'] = str_replace('PHASE_', '', (string) $row['phase']);
        return $row;
    }
}
