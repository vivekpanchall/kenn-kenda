<?php
/**
 * Soft-delete a signup (POST only).
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/helpers.php';

signup_ensure_session();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed.');
}

signup_csrf_validate();

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

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
    signup_flash_set('error', 'This signup is already deleted.');
    signup_redirect(signup_url('view.php', ['id' => $id]));
}

try {
    $sql = 'UPDATE `' . SIGNUP_TABLE . '`
            SET deleted_at = NOW(), updated_at = NOW()
            WHERE id = ? AND deleted_at IS NULL';
    $stmt = signup_db()->prepare($sql);
    $stmt->execute([$id]);

    if ($stmt->rowCount() === 0) {
        signup_flash_set('error', 'Unable to delete signup.');
    } else {
        signup_flash_set('success', 'Signup deleted successfully.');
    }
} catch (PDOException $e) {
    error_log('Signup soft-delete failed: ' . $e->getMessage());
    signup_flash_set('error', 'Unable to delete signup.');
}

signup_redirect(signup_url('index.php'));
