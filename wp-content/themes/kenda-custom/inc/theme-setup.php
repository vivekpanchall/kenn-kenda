<?php
/**
 * Theme supports, menus, image sizes.
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'after_setup_theme',
	function (): void {
		load_theme_textdomain( 'kenda-custom', KENDA_THEME_DIR . '/languages' );

		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 72,
				'width'       => 180,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);

		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'kenda-custom' ),
				'footer'  => __( 'Footer Menu', 'kenda-custom' ),
			)
		);

		add_image_size( 'kenda-hero', 1920, 1080, true );
		add_image_size( 'kenda-portrait', 800, 1000, true );
		add_image_size( 'kenda-card', 720, 480, true );
	}
);

add_filter(
	'get_custom_logo',
	function ( string $html ): string {
		if ( '' === $html ) {
			return $html;
		}
		$html = str_replace( 'class="custom-logo-link"', 'class="custom-logo-link site-brand__logo-link"', $html );
		$html = str_replace( 'class="custom-logo"', 'class="custom-logo site-brand__logo-img"', $html );
		return $html;
	}
);

add_filter(
	'body_class',
	function ( array $classes ): array {
		if ( is_front_page() ) {
			$classes[] = 'has-hero-campaign';
		}
		return $classes;
	}
);

add_filter(
	'nav_menu_link_attributes',
	function ( array $atts, $item ): array {
		if ( ! empty( $item->url ) && str_starts_with( $item->url, '#' ) ) {
			$atts['class'] = trim( ( $atts['class'] ?? '' ) . ' js-scroll-link' );
		}
		return $atts;
	},
	10,
	2
);
