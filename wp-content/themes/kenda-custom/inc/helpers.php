<?php
/**
 * Theme helper functions.
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Site-wide settings (contact, social, donation).
 */
function kenda_site( string $key, $default = '' ) {
	$options = get_option( 'kenda_site_settings', array() );
	return $options[ $key ] ?? $default;
}

/**
 * Homepage section fields.
 */
function kenda_home( string $key, $default = '' ) {
	$options = get_option( 'kenda_homepage_settings', array() );
	if ( is_array( $options ) && array_key_exists( $key, $options ) ) {
		return $options[ $key ];
	}
	$hero_defaults = kenda_homepage_hero_field_defaults();
	if ( array_key_exists( $key, $hero_defaults ) ) {
		return $hero_defaults[ $key ];
	}
	return $default;
}

/**
 * Slide 1 hero copy defaults (PPT-aligned, editable in Homepage Content).
 *
 * @return array<string, string>
 */
function kenda_homepage_hero_field_defaults(): array {
	return array(
		'hero_elect'          => 'ELECT',
		'hero_title'            => 'Kenda Tomes McClain',
		'hero_subtitle'         => 'Campaign Strategy, Service Delivery Timeline & Proposal',
		'hero_eyebrow'          => 'for Mayor of Kansas City, Missouri',
		'hero_credit_line'      => 'Prepared by JPP Consulting',
		'hero_services_line'    => 'AI-Based Political Consulting & Social Sentiment-Driven Campaign Deliverables',
		'hero_website_line'     => 'kendatomesmcclain4kc.com',
		'hero_description'      => '',
	);
}

/**
 * Merge new hero CMS keys into saved homepage settings once.
 */
function kenda_maybe_upgrade_homepage_hero_fields(): void {
	if ( get_option( 'kenda_homepage_hero_fields_v1' ) ) {
		return;
	}
	$options  = get_option( 'kenda_homepage_settings', array() );
	if ( ! is_array( $options ) ) {
		$options = array();
	}
	$defaults = kenda_homepage_hero_field_defaults();
	foreach ( $defaults as $key => $value ) {
		if ( ! isset( $options[ $key ] ) || '' === $options[ $key ] ) {
			$options[ $key ] = $value;
		}
	}
	update_option( 'kenda_homepage_settings', $options );
	update_option( 'kenda_homepage_hero_fields_v1', 1 );
}

add_action( 'init', 'kenda_maybe_upgrade_homepage_hero_fields' );

/**
 * Attachment URL by ID with fallback string URL.
 */
function kenda_media_url( $attachment_id, string $fallback = '' ): string {
	$id = absint( $attachment_id );
	if ( $id ) {
		$url = wp_get_attachment_url( $id );
		if ( $url ) {
			return $url;
		}
	}
	return $fallback;
}

/**
 * Parse gallery attachment IDs from CSV / array.
 *
 * @param mixed $value Raw value.
 * @return list<int>
 */
function kenda_parse_gallery_ids( $value ): array {
	if ( is_array( $value ) ) {
		$parts = $value;
	} else {
		$parts = preg_split( '/[\s,]+/', (string) $value ) ?: array();
	}

	$ids = array();
	foreach ( $parts as $part ) {
		$id = absint( $part );
		if ( $id > 0 ) {
			$ids[] = $id;
		}
	}

	return array_values( array_unique( $ids ) );
}

/**
 * Gallery slideshow items for the homepage.
 *
 * @return list<array{id:int,type:string,url:string,mime:string,alt:string,poster:string}>
 */
function kenda_gallery_items(): array {
	$ids = kenda_parse_gallery_ids( kenda_home( 'gallery_ids', '' ) );
	if ( ! $ids ) {
		return array();
	}

	$items = array();
	foreach ( $ids as $id ) {
		$url  = (string) wp_get_attachment_url( $id );
		$mime = (string) get_post_mime_type( $id );
		if ( '' === $url || '' === $mime ) {
			continue;
		}

		$type = 'image';
		if ( 0 === strpos( $mime, 'video/' ) ) {
			$type = 'video';
		} elseif ( 0 !== strpos( $mime, 'image/' ) ) {
			continue;
		}

		$alt = (string) get_post_meta( $id, '_wp_attachment_image_alt', true );
		if ( '' === $alt ) {
			$alt = (string) get_the_title( $id );
		}

		$poster = '';
		if ( 'video' === $type ) {
			$poster = (string) ( wp_get_attachment_image_url( $id, 'large' ) ?: '' );
		} else {
			$sized = wp_get_attachment_image_url( $id, 'large' );
			if ( $sized ) {
				$url = $sized;
			}
		}

		$items[] = array(
			'id'     => $id,
			'type'   => $type,
			'url'    => $url,
			'mime'   => $mime,
			'alt'    => $alt,
			'poster' => $poster,
		);
	}

	return $items;
}

/**
 * Render attachment image or fallback img tag.
 */
function kenda_render_image( $attachment_id, string $size = 'large', array $attrs = array(), string $fallback_src = '', string $fallback_alt = '' ): string {
	$id = absint( $attachment_id );
	if ( $id ) {
		return wp_get_attachment_image( $id, $size, false, $attrs );
	}
	if ( $fallback_src ) {
		$alt = esc_attr( $attrs['alt'] ?? $fallback_alt );
		$class = esc_attr( $attrs['class'] ?? '' );
		return sprintf(
			'<img src="%s" alt="%s"%s loading="lazy" />',
			esc_url( $fallback_src ),
			$alt,
			$class ? ' class="' . $class . '"' : ''
		);
	}
	return '';
}

/**
 * Sanitize WYSIWYG-ish content for section bodies.
 */
function kenda_content( string $content ): string {
	return wp_kses_post( wpautop( $content ) );
}

/**
 * Primary CTA in header from site settings.
 */
function kenda_header_cta(): array {
	return array(
		'text' => kenda_site( 'header_cta_text', __( 'Donate', 'kenda-custom' ) ),
		'url'  => kenda_site( 'header_cta_url', kenda_site( 'donation_url', '#support' ) ),
	);
}

/**
 * WordPress Custom Logo attachment ID (campaign shield).
 */
function kenda_custom_logo_id(): int {
	return absint( get_theme_mod( 'custom_logo' ) );
}

/**
 * Header brand image — candidate portrait (Homepage Content → About image).
 */
function kenda_header_portrait_id(): int {
	return absint( kenda_home( 'about_image' ) );
}

/**
 * Split CMS hero title into Slide 1 name stack (KENDA / TOMES / McCLAIN).
 *
 * @return list<string>
 */
function kenda_hero_name_parts( string $title ): array {
	$title = trim( $title );
	if ( '' === $title ) {
		return array();
	}

	$words = preg_split( '/\s+/u', $title );
	if ( ! is_array( $words ) ) {
		return array( strtoupper( $title ) );
	}

	$words = array_values( array_filter( $words, static fn( $w ) => '' !== $w ) );
	if ( count( $words ) >= 3 ) {
		return array(
			strtoupper( (string) $words[0] ),
			strtoupper( (string) $words[1] ),
			strtoupper( (string) $words[2] ),
		);
	}

	return array_map( 'strtoupper', $words );
}

/**
 * Split CMS hero title into Slide 1–style name lines (e.g. KENDA TOMES / McCLAIN).
 *
 * @return array{0: string, 1: string}
 */
function kenda_hero_name_lines( string $title ): array {
	$title = trim( $title );
	if ( '' === $title ) {
		return array( '', '' );
	}

	if ( preg_match( '/^(.+?\s+(?:Tomes|tomes))\s+(.+)$/u', $title, $matches ) ) {
		return array(
			strtoupper( $matches[1] ),
			strtoupper( $matches[2] ),
		);
	}

	$parts = preg_split( '/\s+/u', $title, 2 );
	if ( is_array( $parts ) && count( $parts ) === 2 ) {
		return array( strtoupper( $parts[0] ), strtoupper( $parts[1] ) );
	}

	return array( strtoupper( $title ), '' );
}
