<?php
/**
 * Fallback navigation when no menu assigned.
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function kenda_fallback_nav(): void {
	$links = array(
		__( 'About', 'kenda-custom' )        => '#about',
		__( 'Experience', 'kenda-custom' )   => '#experience',
		__( 'Priorities', 'kenda-custom' )   => '#priorities',
		__( 'Vision', 'kenda-custom' )       => '#vision',
		__( 'Get Involved', 'kenda-custom' ) => '#get-involved',
		__( 'Contact', 'kenda-custom' )      => '#contact',
	);
	echo '<ul class="site-nav__list">';
	foreach ( $links as $label => $url ) {
		printf(
			'<li><a class="js-scroll-link" href="%s">%s</a></li>',
			esc_url( $url ),
			esc_html( $label )
		);
	}
	echo '</ul>';
}
