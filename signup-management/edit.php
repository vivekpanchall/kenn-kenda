<?php
/**
 * Edit a signup record (POST update).
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/helpers.php';

signup_ensure_session();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false || $id === null || $id < 1) {
    // Also accept id from POST when form posts to same script with id in query
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
}

if ($id === false || $id === null || $id < 1) {
    signup_flash_set('error', 'Invalid signup ID.');
    signup_redirect(signup_url('index.php'));
}

$id  = (int) $id;
$row = signup_find($id);

if ($row === null) {
    signup_flash_set('error', 'Signup not found.');
    signup_redirect(signup_url('index.php'));
}

if (signup_is_deleted($row)) {
    signup_flash_set('error', 'Deleted signups cannot be edited.');
    signup_redirect(signup_url('view.php', ['id' => $id]));
}

$errors = [];
$values = [
    'name'        => (string) $row['name'],
    'mobile'      => (string) $row['mobile'],
    'zip_code'    => (string) $row['zip_code'],
    'sms_consent' => (int) $row['sms_consent'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    signup_csrf_validate();

    $values['name']        = trim((string) ($_POST['name'] ?? ''));
    $values['mobile']      = trim((string) ($_POST['mobile'] ?? ''));
    $values['zip_code']    = trim((string) ($_POST['zip_code'] ?? ''));
    $values['sms_consent'] = (isset($_POST['sms_consent']) && (string) $_POST['sms_consent'] === '1') ? 1 : 0;

    if ($values['name'] === '' || mb_strlen($values['name']) > 255) {
        $errors['name'] = 'Please enter a valid name (max 255 characters).';
    }

    if ($values['mobile'] === '' || mb_strlen($values['mobile']) > 50) {
        $errors['mobile'] = 'Please enter a valid mobile number (max 50 characters).';
    } elseif (!preg_match('/^[0-9+\-\s().]{7,50}$/', $values['mobile'])) {
        $errors['mobile'] = 'Please enter a valid mobile number.';
    }

    if ($values['zip_code'] === '' || mb_strlen($values['zip_code']) > 20) {
        $errors['zip_code'] = 'Please enter a valid ZIP code (max 20 characters).';
    }

    if ($errors === []) {
        try {
            $prevConsent = (int) $row['sms_consent'];
            $sql = 'UPDATE `' . SIGNUP_TABLE . '`
                    SET name = ?, mobile = ?, zip_code = ?, sms_consent = ?, updated_at = NOW()';
            $bind = [
                $values['name'],
                $values['mobile'],
                $values['zip_code'],
                $values['sms_consent'],
            ];

            // Set consented_at when consent is newly given.
            if ($values['sms_consent'] === 1 && $prevConsent !== 1) {
                $sql .= ', consented_at = NOW()';
            } elseif ($values['sms_consent'] === 0) {
                $sql .= ', consented_at = NULL';
            }

            $sql .= ' WHERE id = ? AND deleted_at IS NULL';
            $bind[] = $id;

            $stmt = signup_db()->prepare($sql);
            $stmt->execute($bind);

            if ($stmt->rowCount() === 0) {
                signup_flash_set('error', 'Unable to update signup.');
            } else {
                signup_flash_set('success', 'Signup updated successfully.');
            }

            signup_redirect(signup_url('view.php', ['id' => $id]));
        } catch (PDOException $e) {
            error_log('Signup update failed: ' . $e->getMessage());
            signup_flash_set('error', 'Unable to update signup.');
            signup_redirect(signup_url('edit.php', ['id' => $id]));
        }
    }
}

$pageTitle = 'Edit Signup #' . $id;

require __DIR__ . '/includes/header.php';
?>

<a class="back-link" href="<?php echo e(signup_url('view.php', ['id' => $id])); ?>">&larr; Back to details</a>

<h1 class="page-title">Edit Signup</h1>

<section class="panel">
    <form method="post" action="<?php echo e(signup_url('edit.php', ['id' => $id])); ?>" class="form-grid" novalidate>
        <?php echo signup_csrf_field(); ?>
        <input type="hidden" name="id" value="<?php echo e((string) $id); ?>">

        <div class="field">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required maxlength="255" value="<?php echo e($values['name']); ?>">
            <?php if (isset($errors['name'])) : ?>
                <div class="field-error"><?php echo e($errors['name']); ?></div>
            <?php endif; ?>
        </div>

        <div class="field">
            <label for="mobile">Mobile</label>
            <input type="tel" id="mobile" name="mobile" required maxlength="50" value="<?php echo e($values['mobile']); ?>">
            <?php if (isset($errors['mobile'])) : ?>
                <div class="field-error"><?php echo e($errors['mobile']); ?></div>
            <?php endif; ?>
        </div>

        <div class="field">
            <label for="zip_code">ZIP Code</label>
            <input type="text" id="zip_code" name="zip_code" required maxlength="20" value="<?php echo e($values['zip_code']); ?>">
            <?php if (isset($errors['zip_code'])) : ?>
                <div class="field-error"><?php echo e($errors['zip_code']); ?></div>
            <?php endif; ?>
        </div>

        <div class="field">
            <label for="sms_consent">SMS Consent</label>
            <select id="sms_consent" name="sms_consent">
                <option value="1" <?php echo $values['sms_consent'] === 1 ? 'selected' : ''; ?>>Given</option>
                <option value="0" <?php echo $values['sms_consent'] === 0 ? 'selected' : ''; ?>>Not Given</option>
            </select>
        </div>

        <p class="field-hint">ID, Created At, Updated At, and Deleted At cannot be edited here.</p>

        <div class="form-actions">
            <button type="submit" class="btn btn--primary">Save changes</button>
            <a class="btn btn--secondary" href="<?php echo e(signup_url('view.php', ['id' => $id])); ?>">Cancel</a>
        </div>
    </form>
</section>

<?php
require __DIR__ . '/includes/footer.php';
