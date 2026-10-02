<?php
/**
 * CSRF token helpers (session-based).
 */

declare(strict_types=1);

/**
 * Ensure a session is started.
 */
function signup_ensure_session(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

/**
 * Get or create the CSRF token.
 */
function signup_csrf_token(): string
{
    signup_ensure_session();

    if (empty($_SESSION['signup_csrf_token']) || !is_string($_SESSION['signup_csrf_token'])) {
        $_SESSION['signup_csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['signup_csrf_token'];
}

/**
 * Render a hidden CSRF input field.
 */
function signup_csrf_field(): string
{
    $token = htmlspecialchars(signup_csrf_token(), ENT_QUOTES, 'UTF-8');
    return '<input type="hidden" name="csrf_token" value="' . $token . '">';
}

/**
 * Validate CSRF token from POST. Exits with 403 on failure.
 */
function signup_csrf_validate(): void
{
    signup_ensure_session();

    $sessionToken = $_SESSION['signup_csrf_token'] ?? '';
    $postedToken  = $_POST['csrf_token'] ?? '';

    if (
        !is_string($sessionToken)
        || $sessionToken === ''
        || !is_string($postedToken)
        || !hash_equals($sessionToken, $postedToken)
    ) {
        http_response_code(403);
        exit('Invalid security token. Please go back and try again.');
    }
}
