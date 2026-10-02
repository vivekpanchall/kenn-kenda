<?php
/**
 * HTML header layout.
 *
 * @var string $pageTitle
 */

declare(strict_types=1);

if (!isset($pageTitle)) {
    $pageTitle = SIGNUP_APP_NAME;
}

$flash = signup_flash_get();
$base  = signup_base_url();
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($pageTitle); ?> — <?php echo e(SIGNUP_APP_NAME); ?></title>
    <link rel="stylesheet" href="<?php echo e($base); ?>/assets/css/admin.css">
</head>
<body>
<div class="app">
    <header class="app-header">
        <div class="app-header__inner">
            <a class="app-header__brand" href="<?php echo e(signup_url('index.php')); ?>">
                <?php echo e(SIGNUP_APP_NAME); ?>
            </a>
        </div>
    </header>

    <main class="app-main">
        <?php if ($flash !== null && $flash['message'] !== '') : ?>
            <div class="alert alert--<?php echo e($flash['type'] === 'error' ? 'error' : 'success'); ?>" role="alert">
                <?php echo e($flash['message']); ?>
            </div>
        <?php endif; ?>
