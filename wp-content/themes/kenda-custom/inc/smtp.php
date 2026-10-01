<?php
/**
 * SMTP configuration for Kenda Custom theme.
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'phpmailer_init',
	function ( $phpmailer ): void {

		$phpmailer->isSMTP();

		$phpmailer->Host       = defined( 'KENDA_SMTP_HOST' ) ? KENDA_SMTP_HOST : '';
		$phpmailer->Port       = defined( 'KENDA_SMTP_PORT' ) ? KENDA_SMTP_PORT : 587;
		$phpmailer->Username   = defined( 'KENDA_SMTP_USER' ) ? KENDA_SMTP_USER : '';
		$phpmailer->Password   = defined( 'KENDA_SMTP_PASSWORD' ) ? KENDA_SMTP_PASSWORD : '';
		$phpmailer->SMTPSecure = defined( 'KENDA_SMTP_ENCRYPTION' ) ? KENDA_SMTP_ENCRYPTION : 'tls';
		$phpmailer->SMTPAuth   = true;

		$phpmailer->From     = $phpmailer->Username;
		$phpmailer->FromName = 'Kenda Tomes McClain Campaign';
	}
);