<?php
declare(strict_types=1);

function config(string $key, mixed $default = null): mixed
{
    $value = $GLOBALS['__config'];
    foreach (explode('.', $key) as $part) {
        if (!is_array($value) || !array_key_exists($part, $value)) {
            return $default;
        }
        $value = $value[$part];
    }
    return $value;
}

function e(mixed $value): string
{
    if ($value === null || is_array($value) || is_object($value)) {
        return '';
    }
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
}

function base_path(): string
{
    static $base = null;
    if ($base === null) {
        $dir  = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
        $base = rtrim($dir, '/');
    }
    return $base;
}

function url(string $path = '', array $query = []): string
{
    $url = base_path() . '/' . ltrim($path, '/');
    if ($query) {
        $url .= '?' . http_build_query($query, '', '&', PHP_QUERY_RFC3986);
    }
    return $url;
}

function asset(string $path): string
{
    $file    = APP_ROOT . '/assets/' . ltrim($path, '/');
    $version = is_file($file) ? (string) filemtime($file) : '1';
    return url('assets/' . ltrim($path, '/')) . '?v=' . $version;
}

function partial(string $name, array $vars = []): void
{
    render_include(APP_ROOT . '/includes/partials/' . basename($name) . '.php', $vars);
}

function illustration(string $name, array $vars = []): void
{
    render_include(APP_ROOT . '/includes/illustrations/' . basename($name) . '.php', $vars);
}

function render_include(string $file, array $vars): void
{
    if (!is_file($file)) {
        return;
    }
    (static function (string $__file, array $__vars): void {
        extract($__vars, EXTR_SKIP);
        require $__file;
    })($file, $vars);
}

function csrf_field(): string
{
    return '<input type="hidden" name="_token" value="' . e(Security::csrfToken()) . '">';
}

function trials(): TrialService
{
    static $service = null;
    return $service ??= new TrialService(
        config('app.data_source') === 'mysql' ? new MysqlTrialRepository() : new SampleTrialRepository(),
        content()
    );
}

function content(): ContentService
{
    static $service = null;
    return $service ??= new ContentService(new ContentRepository());
}

function format_date(?string $date): string
{
    if (!$date) {
        return '';
    }
    $ts = strtotime($date);
    return $ts ? date('j M Y', $ts) : '';
}

function registry_url(string $id): ?string
{
    $id = trim($id);
    if (preg_match('/^NCT\d{8}$/', $id)) {
        return 'https://clinicaltrials.gov/study/' . $id;
    }
    if (preg_match('#^CTRI/\d{4}/\d{2,3}/\d{6}$#', $id)) {
        return 'https://ctri.nic.in/Clinicaltrials/advsearch.php';
    }
    return null;
}

function whatsapp_chat_url(string $text = 'Hi'): string
{
    $number = preg_replace('/\D/', '', (string) config('contact.whatsapp_chat', ''));
    return 'https://wa.me/' . (strlen($number) >= 10 ? $number : '') . '?text=' . rawurlencode($text);
}

function legal_html(string $html): string
{
    $g = config('contact.grievance');
    $tokens = [
        '{effective}'       => e(format_date(config('legal.effective'))),
        '{notice_version}'  => e(config('app.notice_version')),
        '{contact_email}'   => e(config('contact.email')),
        '{contact_whatsapp}' => e(config('contact.whatsapp')),
        '{grievance_name}'  => e($g['name']),
        '{grievance_email}' => e($g['email']),
        '{grievance_phone}' => e($g['phone']),
    ];
    $html = strtr($html, $tokens);
    return preg_replace_callback('/\{link:([a-z0-9\-]+\.php)(#[a-z0-9\-]+)?\}/', static fn ($m) => e(url($m[1])) . ($m[2] ?? ''), $html) ?? $html;
}
