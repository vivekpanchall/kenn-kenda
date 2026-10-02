<?php
/**
 * Signup listing — search, filters, sort, pagination.
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/helpers.php';

signup_ensure_session();

$params = signup_parse_list_params();
[$whereSql, $whereBind] = signup_build_where($params);

$allowedSort = signup_allowed_sort_columns();
$orderColumn = $allowedSort[$params['sort']];
$orderDir    = strtoupper($params['dir']); // ASC or DESC — already whitelisted

$perPage = SIGNUP_PER_PAGE;
$offset  = ($params['page'] - 1) * $perPage;

$pdo   = signup_db();
$table = '`' . SIGNUP_TABLE . '`';

try {
    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM {$table} WHERE {$whereSql}");
    $countStmt->execute($whereBind);
    $total = (int) $countStmt->fetchColumn();

    $totalPages = max(1, (int) ceil($total / $perPage));
    if ($params['page'] > $totalPages) {
        $params['page'] = $totalPages;
        $offset = ($params['page'] - 1) * $perPage;
    }

    $sql = "SELECT id, name, mobile, zip_code, sms_consent, consented_at, created_at, updated_at, deleted_at
            FROM {$table}
            WHERE {$whereSql}
            ORDER BY `{$orderColumn}` {$orderDir}, id DESC
            LIMIT ? OFFSET ?";

    $stmt = $pdo->prepare($sql);
    $i = 1;
    foreach ($whereBind as $value) {
        $stmt->bindValue($i++, $value);
    }
    $stmt->bindValue($i++, $perPage, PDO::PARAM_INT);
    $stmt->bindValue($i, $offset, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log('Signup list query failed: ' . $e->getMessage());
    $total      = 0;
    $totalPages = 1;
    $rows       = [];
    signup_flash_set('error', 'Unable to load signup records.');
}

$pageTitle = 'Signups';
$from = $total === 0 ? 0 : $offset + 1;
$to   = min($offset + $perPage, $total);

$baseQuery = signup_list_query_params($params);

require __DIR__ . '/includes/header.php';
?>

<h1 class="page-title">Signup Management</h1>

<section class="panel">
    <form class="filters" method="get" action="<?php echo e(signup_url('index.php')); ?>">
        <div class="filters__row filters__row--controls">
            <div class="field">
                <label for="search">Search</label>
                <input
                    type="text"
                    id="search"
                    name="search"
                    value="<?php echo e($params['search']); ?>"
                    placeholder="Search by name, mobile or ZIP code"
                    autocomplete="off"
                >
            </div>

            <div class="field">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="all" <?php echo $params['status'] === 'all' ? 'selected' : ''; ?>>All</option>
                    <option value="active" <?php echo $params['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                    <option value="deleted" <?php echo $params['status'] === 'deleted' ? 'selected' : ''; ?>>Deleted</option>
                </select>
            </div>

            <div class="field">
                <label for="consent">SMS Consent</label>
                <select id="consent" name="consent">
                    <option value="all" <?php echo $params['consent'] === 'all' ? 'selected' : ''; ?>>All</option>
                    <option value="given" <?php echo $params['consent'] === 'given' ? 'selected' : ''; ?>>Given</option>
                    <option value="not_given" <?php echo $params['consent'] === 'not_given' ? 'selected' : ''; ?>>Not Given</option>
                </select>
            </div>

            <div class="btn-row">
                <button type="submit" class="btn btn--primary">Search</button>
                <a class="btn btn--secondary" href="<?php echo e(signup_url('index.php')); ?>">Reset</a>
            </div>
        </div>
    </form>
</section>

<div class="meta-bar">
    <span>
        <?php if ($total === 0) : ?>
            Showing 0 records
        <?php else : ?>
            Showing <?php echo e((string) $from); ?>–<?php echo e((string) $to); ?> of <?php echo e((string) $total); ?>
        <?php endif; ?>
    </span>
</div>

<?php if ($rows === []) : ?>
    <div class="empty-state">No signup records found.</div>
<?php else : ?>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <?php
                    $cols = [
                        'id'           => 'ID',
                        'name'         => 'Name',
                        'mobile'       => 'Mobile',
                        'zip_code'     => 'ZIP Code',
                        'sms_consent'  => 'SMS Consent',
                        'consented_at' => 'Consented At',
                        'created_at'   => 'Created At',
                        'updated_at'   => 'Updated At',
                        'status'       => 'Status',
                    ];
                    foreach ($cols as $key => $label) :
                        ?>
                        <th>
                            <a href="<?php echo e(signup_sort_url($key, $params)); ?>">
                                <?php echo e($label); ?><?php echo e(signup_sort_indicator($key, $params)); ?>
                            </a>
                        </th>
                    <?php endforeach; ?>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row) :
                    $deleted = signup_is_deleted($row);
                    ?>
                    <tr>
                        <td><?php echo e((string) $row['id']); ?></td>
                        <td><?php echo e((string) $row['name']); ?></td>
                        <td><?php echo e((string) $row['mobile']); ?></td>
                        <td><?php echo e((string) $row['zip_code']); ?></td>
                        <td>
                            <?php if ((int) $row['sms_consent'] === 1) : ?>
                                <span class="badge badge--given">Given</span>
                            <?php else : ?>
                                <span class="badge badge--not-given">Not Given</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo signup_format_datetime($row['consented_at'] ?? null); ?></td>
                        <td><?php echo signup_format_datetime($row['created_at'] ?? null); ?></td>
                        <td><?php echo signup_format_datetime($row['updated_at'] ?? null); ?></td>
                        <td>
                            <?php if ($deleted) : ?>
                                <span class="badge badge--deleted">Deleted</span>
                            <?php else : ?>
                                <span class="badge badge--active">Active</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="actions">
                                <a class="btn btn--sm btn--secondary" href="<?php echo e(signup_url('view.php', ['id' => $row['id']])); ?>">View</a>
                                <?php if (!$deleted) : ?>
                                    <a class="btn btn--sm btn--secondary" href="<?php echo e(signup_url('edit.php', ['id' => $row['id']])); ?>">Edit</a>
                                    <form
                                        class="js-confirm-delete"
                                        method="post"
                                        action="<?php echo e(signup_url('delete.php')); ?>"
                                        data-confirm="Are you sure you want to delete this signup?"
                                        style="display:inline;"
                                    >
                                        <?php echo signup_csrf_field(); ?>
                                        <input type="hidden" name="id" value="<?php echo e((string) $row['id']); ?>">
                                        <button type="submit" class="btn btn--sm btn--danger">Delete</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if ($totalPages > 1) : ?>
        <nav class="pagination" aria-label="Pagination">
            <?php
            $prevPage = $params['page'] - 1;
            $nextPage = $params['page'] + 1;
            $prevParams = $baseQuery;
            $nextParams = $baseQuery;
            if ($prevPage > 1) {
                $prevParams['page'] = $prevPage;
            }
            $nextParams['page'] = $nextPage;
            ?>

            <?php if ($params['page'] > 1) : ?>
                <a href="<?php echo e(signup_url('index.php', $prevParams)); ?>">Previous</a>
            <?php else : ?>
                <span class="is-disabled">Previous</span>
            <?php endif; ?>

            <?php foreach (signup_pagination_pages($params['page'], $totalPages) as $p) : ?>
                <?php if ($p === null) : ?>
                    <span>…</span>
                <?php elseif ($p === $params['page']) : ?>
                    <span class="is-current" aria-current="page"><?php echo e((string) $p); ?></span>
                <?php else : ?>
                    <?php
                    $pageParams = $baseQuery;
                    if ($p > 1) {
                        $pageParams['page'] = $p;
                    }
                    ?>
                    <a href="<?php echo e(signup_url('index.php', $pageParams)); ?>"><?php echo e((string) $p); ?></a>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php if ($params['page'] < $totalPages) : ?>
                <a href="<?php echo e(signup_url('index.php', $nextParams)); ?>">Next</a>
            <?php else : ?>
                <span class="is-disabled">Next</span>
            <?php endif; ?>
        </nav>
    <?php endif; ?>
<?php endif; ?>

<?php
require __DIR__ . '/includes/footer.php';
