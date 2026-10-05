<?php
/**
 * Kenda Custom theme bootstrap.
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'KENDA_THEME_VERSION', '1.6.3' );
define( 'KENDA_THEME_DIR', get_template_directory() );
define( 'KENDA_THEME_URI', get_template_directory_uri() );

require_once KENDA_THEME_DIR . '/inc/theme-setup.php';
require_once KENDA_THEME_DIR . '/inc/enqueue.php';
require_once KENDA_THEME_DIR . '/inc/helpers.php';
require_once KENDA_THEME_DIR . '/inc/custom-post-types.php';
require_once KENDA_THEME_DIR . '/inc/custom-fields.php';
require_once KENDA_THEME_DIR . '/inc/contact-handler.php';
require_once KENDA_THEME_DIR . '/inc/text-signups.php';
require_once KENDA_THEME_DIR . '/inc/smtp.php';
require_once KENDA_THEME_DIR . '/inc/seed.php';
require_once KENDA_THEME_DIR . '/inc/nav-fallback.php';
require_once KENDA_THEME_DIR . '/inc/ppt-deck.php';
require_once KENDA_THEME_DIR . '/inc/ppt-deck-admin.php';
