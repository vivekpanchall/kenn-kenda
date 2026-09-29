<?php
/**
 * Styles and scripts.
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'wp_enqueue_scripts',
	function (): void {
		wp_enqueue_style(
			'kenda-fonts',
			'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Source+Sans+3:ital,wght@0,400;0,600;0,700;1,400&display=swap',
			array(),
			null
		);

		wp_enqueue_style(
			'kenda-main',
			KENDA_THEME_URI . '/assets/css/main.css',
			array( 'kenda-fonts' ),
			KENDA_THEME_VERSION
		);

		wp_enqueue_style(
			'kenda-responsive',
			KENDA_THEME_URI . '/assets/css/responsive.css',
			array( 'kenda-main' ),
			KENDA_THEME_VERSION
		);

		wp_enqueue_style(
			'kenda-contact-section',
			KENDA_THEME_URI . '/assets/css/contact-section.css',
			array( 'kenda-responsive' ),
			KENDA_THEME_VERSION
		);

		wp_enqueue_style(
			'kenda-about-section',
			KENDA_THEME_URI . '/assets/css/about-section.css',
			array( 'kenda-responsive' ),
			KENDA_THEME_VERSION
		);

		if ( is_front_page() ) {
			wp_enqueue_style(
				'kenda-campaign-home',
				KENDA_THEME_URI . '/assets/css/campaign-home.css',
				array( 'kenda-about-section' ),
				KENDA_THEME_VERSION
			);
			wp_enqueue_style(
				'kenda-home-dynamic',
				KENDA_THEME_URI . '/assets/css/home-dynamic.css',
				array( 'kenda-campaign-home' ),
				KENDA_THEME_VERSION
			);
		}

		wp_enqueue_script(
			'kenda-navigation',
			KENDA_THEME_URI . '/assets/js/navigation.js',
			array(),
			KENDA_THEME_VERSION,
			array( 'strategy' => 'defer', 'in_footer' => true )
		);

		wp_enqueue_script(
			'kenda-animations',
			KENDA_THEME_URI . '/assets/js/animations.js',
			array(),
			KENDA_THEME_VERSION,
			array( 'strategy' => 'defer', 'in_footer' => true )
		);

		wp_enqueue_script(
			'kenda-contact',
			KENDA_THEME_URI . '/assets/js/contact.js',
			array(),
			KENDA_THEME_VERSION,
			array( 'strategy' => 'defer', 'in_footer' => true )
		);

		wp_enqueue_script(
			'kenda-main',
			KENDA_THEME_URI . '/assets/js/main.js',
			array( 'kenda-navigation', 'kenda-animations', 'kenda-contact' ),
			KENDA_THEME_VERSION,
			array( 'strategy' => 'defer', 'in_footer' => true )
		);

		wp_localize_script(
			'kenda-contact',
			'kendaContact',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'kenda_contact' ),
			)
		);
	}
);

add_action(
	'admin_enqueue_scripts',
	function ( string $hook ): void {
		if ( ! str_contains( $hook, 'kenda' ) && 'post.php' !== $hook && 'post-new.php' !== $hook ) {
			return;
		}
		wp_enqueue_media();
		wp_enqueue_script(
			'kenda-admin',
			KENDA_THEME_URI . '/assets/js/admin-media.js',
			array( 'jquery' ),
			KENDA_THEME_VERSION,
			true
		);
	}
);
