<?php
/**
 * Standalone signup management configuration.
 *
 * Uses the same MySQL database as the WordPress site (see wp-config.php).
 * Does NOT load WordPress.
 */

declare(strict_types=1);

define('SIGNUP_DB_HOST', 'localhost');
define('SIGNUP_DB_NAME', 'kenda_wordpress');
define('SIGNUP_DB_USER', 'root');
define('SIGNUP_DB_PASS', '');
define('SIGNUP_DB_CHARSET', 'utf8mb4');

/** Table that stores SIGN ME UP form submissions. */
define('SIGNUP_TABLE', 'wp_kenda_text_signups');

define('SIGNUP_PER_PAGE', 20);

define('SIGNUP_APP_NAME', 'Signup Management');

/** Absolute filesystem path to the signup-management root. */
define('SIGNUP_ROOT', dirname(__DIR__));
