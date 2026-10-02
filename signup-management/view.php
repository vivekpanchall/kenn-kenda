<?php
/**
 * View a single signup record.
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/helpers.php';

signup_ensure_session();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id === false || $id === null || $id < 1) {
    signup_flash_set('error', 'Invalid signup ID.');
    signup_redirect(signup_url('index.php'));
}

$row = signup_find((int) $id);

if ($row === null) {
    signup_flash_set('error', 'Signup not found.');
    signup_redirect(signup_url('index.php'));
}

$pageTitle = 'View Signup #' . $id;
$deleted   = signup_is_deleted($row);

require __DIR__ . '/includes/header.php';
?>

<a class="back-link" href="<?php echo e(signup_url('index.php')); ?>">&larr; Back to listing</a>

<h1 class="page-title">View Signup</h1>

<section class="panel">
    <ul class="detail-list">
        <li>
            <span class="detail-list__label">ID</span>
            <span><?php echo e((string) $row['id']); ?></span>
        </li>
        <li>
            <span class="detail-list__label">Name</span>
            <span><?php echo e((string) $row['name']); ?></span>
        </li>
        <li>
            <span class="detail-list__label">Mobile</span>
            <span><?php echo e((string) $row['mobile']); ?></span>
        </li>
        <li>
            <span class="detail-list__label">ZIP Code</span>
            <span><?php echo e((string) $row['zip_code']); ?></span>
        </li>
        <li>
            <span class="detail-list__label">SMS Consent</span>
            <span>
                <?php if ((int) $row['sms_consent'] === 1) : ?>
                    <span class="badge badge--given">Given</span>
                <?php else : ?>
                    <span class="badge badge--not-given">Not Given</span>
                <?php endif; ?>
            </span>
        </li>
        <li>
            <span class="detail-list__label">Consented At</span>
            <span><?php echo signup_format_datetime($row['consented_at'] ?? null); ?></span>
        </li>
        <li>
            <span class="detail-list__label">Created At</span>
            <span><?php echo signup_format_datetime($row['created_at'] ?? null); ?></span>
        </li>
        <li>
            <span class="detail-list__label">Updated At</span>
            <span><?php echo signup_format_datetime($row['updated_at'] ?? null); ?></span>
        </li>
        <li>
            <span class="detail-list__label">Status</span>
            <span>
                <?php if ($deleted) : ?>
                    <span class="badge badge--deleted">Deleted</span>
                <?php else : ?>
                    <span class="badge badge--active">Active</span>
                <?php endif; ?>
            </span>
        </li>
    </ul>

    <div class="form-actions" style="margin-top:1.25rem;">
        <?php if (!$deleted) : ?>
            <a class="btn btn--primary" href="<?php echo e(signup_url('edit.php', ['id' => $row['id']])); ?>">Edit</a>
            <form
                class="js-confirm-delete"
                method="post"
                action="<?php echo e(signup_url('delete.php')); ?>"
                data-confirm="Are you sure you want to delete this signup?"
                style="display:inline;"
            >
                <?php echo signup_csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e((string) $row['id']); ?>">
                <button type="submit" class="btn btn--danger">Delete</button>
            </form>
        <?php endif; ?>
        <a class="btn btn--secondary" href="<?php echo e(signup_url('index.php')); ?>">Back to list</a>
    </div>
</section>

<?php
require __DIR__ . '/includes/footer.php';
