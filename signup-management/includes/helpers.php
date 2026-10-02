<?php
/**
 * Shared helpers for signup management.
 */

declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/csrf.php';

/**
 * Escape for HTML output.
 */
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/**
 * Module base URL path (no trailing slash), e.g. /kenn-kenda/signup-management
 */
function signup_base_url(): string
{
    $script = $_SERVER['SCRIPT_NAME'] ?? '';
    $dir    = str_replace('\\', '/', dirname($script));
    return rtrim($dir, '/');
}

/**
 * Build a URL within this module, preserving optional query params.
 *
 * @param array<string, scalar|null> $params
 */
function signup_url(string $path = 'index.php', array $params = []): string
{
    $path = ltrim($path, '/');
    $url  = signup_base_url() . '/' . $path;

    $params = array_filter(
        $params,
        static fn($v) => $v !== null && $v !== ''
    );

    if ($params !== []) {
        $url .= '?' . http_build_query($params);
    }

    return $url;
}

/**
 * Flash a one-time message into the session.
 */
function signup_flash_set(string $type, string $message): void
{
    signup_ensure_session();
    $_SESSION['signup_flash'] = [
        'type'    => $type,
        'message' => $message,
    ];
}

/**
 * Get and clear flash message.
 *
 * @return array{type:string,message:string}|null
 */
function signup_flash_get(): ?array
{
    signup_ensure_session();

    if (empty($_SESSION['signup_flash']) || !is_array($_SESSION['signup_flash'])) {
        return null;
    }

    $flash = $_SESSION['signup_flash'];
    unset($_SESSION['signup_flash']);

    return [
        'type'    => (string) ($flash['type'] ?? 'info'),
        'message' => (string) ($flash['message'] ?? ''),
    ];
}

/**
 * Whitelist of sortable columns (URL key => SQL column).
 *
 * @return array<string, string>
 */
function signup_allowed_sort_columns(): array
{
    return [
        'id'           => 'id',
        'name'         => 'name',
        'mobile'       => 'mobile',
        'zip_code'     => 'zip_code',
        'sms_consent'  => 'sms_consent',
        'consented_at' => 'consented_at',
        'created_at'   => 'created_at',
        'updated_at'   => 'updated_at',
        'status'       => 'deleted_at',
    ];
}

/**
 * Parse listing query params from GET.
 *
 * @return array{
 *   search:string,
 *   status:string,
 *   consent:string,
 *   sort:string,
 *   dir:string,
 *   page:int
 * }
 */
function signup_parse_list_params(): array
{
    $search = trim((string) ($_GET['search'] ?? ''));
    if (mb_strlen($search) > 200) {
        $search = mb_substr($search, 0, 200);
    }

    $status = strtolower(trim((string) ($_GET['status'] ?? 'all')));
    if (!in_array($status, ['all', 'active', 'deleted'], true)) {
        $status = 'all';
    }

    $consent = strtolower(trim((string) ($_GET['consent'] ?? 'all')));
    if (!in_array($consent, ['all', 'given', 'not_given'], true)) {
        $consent = 'all';
    }

    $allowed = signup_allowed_sort_columns();
    $sortKey = strtolower(trim((string) ($_GET['sort'] ?? 'created_at')));
    if (!isset($allowed[$sortKey])) {
        $sortKey = 'created_at';
    }

    $dir = strtolower(trim((string) ($_GET['dir'] ?? 'desc')));
    if (!in_array($dir, ['asc', 'desc'], true)) {
        $dir = 'desc';
    }

    $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
    if ($page === false || $page === null || $page < 1) {
        $page = 1;
    }

    return [
        'search'  => $search,
        'status'  => $status,
        'consent' => $consent,
        'sort'    => $sortKey,
        'dir'     => $dir,
        'page'    => (int) $page,
    ];
}

/**
 * Query params for preserving filters (without page unless requested).
 *
 * @param array{search:string,status:string,consent:string,sort:string,dir:string,page?:int} $params
 * @return array<string, scalar>
 */
function signup_list_query_params(array $params, bool $includePage = false): array
{
    $out = [];

    if ($params['search'] !== '') {
        $out['search'] = $params['search'];
    }
    if ($params['status'] !== 'all') {
        $out['status'] = $params['status'];
    }
    if ($params['consent'] !== 'all') {
        $out['consent'] = $params['consent'];
    }

    $isDefaultSort = ($params['sort'] === 'created_at' && $params['dir'] === 'desc');
    if (!$isDefaultSort) {
        $out['sort'] = $params['sort'];
        $out['dir']  = $params['dir'];
    }

    if ($includePage && isset($params['page']) && (int) $params['page'] > 1) {
        $out['page'] = (int) $params['page'];
    }

    return $out;
}

/**
 * Build WHERE clause + bindings for list/count queries.
 *
 * @param array{search:string,status:string,consent:string} $params
 * @return array{0:string,1:array<int, mixed>}
 */
function signup_build_where(array $params): array
{
    $where  = ['1=1'];
    $bind   = [];

    if ($params['search'] !== '') {
        $like = '%' . $params['search'] . '%';
        $where[] = '(name LIKE ? OR mobile LIKE ? OR zip_code LIKE ?)';
        $bind[]  = $like;
        $bind[]  = $like;
        $bind[]  = $like;
    }

    if ($params['status'] === 'active') {
        $where[] = 'deleted_at IS NULL';
    } elseif ($params['status'] === 'deleted') {
        $where[] = 'deleted_at IS NOT NULL';
    }

    if ($params['consent'] === 'given') {
        $where[] = 'sms_consent = ?';
        $bind[]  = 1;
    } elseif ($params['consent'] === 'not_given') {
        $where[] = 'sms_consent = ?';
        $bind[]  = 0;
    }

    return [implode(' AND ', $where), $bind];
}

/**
 * Fetch a single signup by ID.
 *
 * @return array<string, mixed>|null
 */
function signup_find(int $id): ?array
{
    $sql = 'SELECT * FROM `' . SIGNUP_TABLE . '` WHERE id = ? LIMIT 1';
    $stmt = signup_db()->prepare($sql);
    $stmt->execute([$id]);
    $row = $stmt->fetch();

    return $row === false ? null : $row;
}

/**
 * Format datetime for display.
 */
function signup_format_datetime(?string $value): string
{
    if ($value === null || $value === '' || $value === '0000-00-00 00:00:00') {
        return '—';
    }

    $ts = strtotime($value);
    if ($ts === false) {
        return e($value);
    }

    return e(date('Y-m-d H:i', $ts));
}

/**
 * Human-readable SMS consent label.
 */
function signup_consent_label(mixed $value): string
{
    return ((int) $value === 1) ? 'Given' : 'Not Given';
}

/**
 * Whether the record is soft-deleted.
 */
function signup_is_deleted(array $row): bool
{
    return !empty($row['deleted_at']);
}

/**
 * Status label.
 */
function signup_status_label(array $row): string
{
    return signup_is_deleted($row) ? 'Deleted' : 'Active';
}

/**
 * Redirect helper.
 */
function signup_redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

/**
 * Build sort link for a column header.
 *
 * @param array{search:string,status:string,consent:string,sort:string,dir:string,page:int} $params
 */
function signup_sort_url(string $column, array $params): string
{
    $dir = 'asc';
    if ($params['sort'] === $column && $params['dir'] === 'asc') {
        $dir = 'desc';
    }

    $q = signup_list_query_params([
        'search'  => $params['search'],
        'status'  => $params['status'],
        'consent' => $params['consent'],
        'sort'    => $column,
        'dir'     => $dir,
    ]);

    // Always include sort/dir for clarity when toggling
    $q['sort'] = $column;
    $q['dir']  = $dir;

    return signup_url('index.php', $q);
}

/**
 * Sort indicator arrow for column headers.
 */
function signup_sort_indicator(string $column, array $params): string
{
    if ($params['sort'] !== $column) {
        return '';
    }

    return $params['dir'] === 'asc' ? ' ↑' : ' ↓';
}

/**
 * Compact pagination page list.
 *
 * @return list<int|null> null = ellipsis
 */
function signup_pagination_pages(int $current, int $totalPages): array
{
    if ($totalPages <= 1) {
        return [];
    }

    if ($totalPages <= 7) {
        return range(1, $totalPages);
    }

    $pages = [1];

    $start = max(2, $current - 1);
    $end   = min($totalPages - 1, $current + 1);

    if ($start > 2) {
        $pages[] = null;
    }

    for ($i = $start; $i <= $end; $i++) {
        $pages[] = $i;
    }

    if ($end < $totalPages - 1) {
        $pages[] = null;
    }

    $pages[] = $totalPages;

    return $pages;
}
