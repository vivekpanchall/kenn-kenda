<?php
/**
 * PDO database connection for signup management.
 */

declare(strict_types=1);

require_once __DIR__ . '/config.php';

/**
 * @return PDO
 */
function signup_db(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dsn = sprintf(
        'mysql:host=%s;dbname=%s;charset=%s',
        SIGNUP_DB_HOST,
        SIGNUP_DB_NAME,
        SIGNUP_DB_CHARSET
    );

    try {
        $pdo = new PDO($dsn, SIGNUP_DB_USER, SIGNUP_DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    } catch (PDOException $e) {
        error_log('Signup management DB connection failed: ' . $e->getMessage());
        http_response_code(500);
        exit('Unable to connect to the database. Please try again later.');
    }

    return $pdo;
}
