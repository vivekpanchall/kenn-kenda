<?php
/**
 * Campaign hero — Slide 1 copy from CMS + video + shield.
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);

$video_url   = kenda_media_url( kenda_home( 'hero_video' ), KENDA_THEME_URI . '/assets/videos/hero-campaign.mp4' );

$brand_alt   = kenda_site( 'site_name', __( 'Kenda Tomes McClain', 'kenda-custom' ) );
$elect       = (string) kenda_home( 'hero_elect', 'ELECT' );
$title       = (string) kenda_home( 'hero_title' );
$subtitle    = (string) kenda_home( 'hero_subtitle' );
$eyebrow     = (string) kenda_home( 'hero_eyebrow' );
$credit      = (string) kenda_home( 'hero_credit_line' );
$services    = (string) kenda_home( 'hero_services_line' );
$website     = (string) kenda_home( 'hero_website_line' );
$desc        = (string) kenda_home( 'hero_description' );
$p_text      = kenda_home( 'hero_primary_text' );
$p_url       = kenda_home( 'hero_primary_url', '#get-involved' );
$s_text      = kenda_home( 'hero_secondary_text' );
$s_url       = kenda_home( 'hero_secondary_url', '#support' );
// $name_parts  = kenda_hero_name_parts( $title );
$words = preg_split( '/\s+/', trim( $title ) );

$name_parts = array(
    implode( ' ', array_slice( $words, 0, 2 ) ),
    implode( ' ', array_slice( $words, 2, 3 ) ),
    implode( ' ', array_slice( $words, 5, 2 ) ),
    implode( ' ', array_slice( $words, 7 ) ),
);

$logo_id = (int) kenda_home( 'hero_poster', 0 );
$logo_fb     = KENDA_THEME_URI . '/assets/images/campaign-logo-shield.png';

$website_href = $website;
if ( $website_href && preg_match( '/^[\d\s.\-+()]+$/', $website_href ) ) {
	$website_href = 'tel:' . preg_replace( '/[^\d+]/', '', $website_href );
} elseif ( $website_href && ! str_contains( $website_href, '://' ) ) {
	$website_href = 'https://' . ltrim( $website_href, '/' );
}
?>
<section class="hero hero--campaign " id="home" aria-label="<?php esc_attr_e( 'Introduction', 'kenda-custom' ); ?>">
	<div class="hero__media" aria-hidden="true">
		<video
			class="hero__video"
			playsinline
			loop
			autoplay
			muted
			preload="auto"
			data-hero-video
		>
			<source src="<?php echo esc_url( $video_url ); ?>" type="video/mp4" />
		</video>
		<button
			type="button"
			class="hero__scroll-hint hero__audio-toggle"
			aria-label="Listen"
			aria-pressed="false"
			title="Listen"
			data-hero-audio-toggle
		>
			Listen
		</button>
		<div class="hero__overlay hero__overlay--accent"></div>
	</div>

	<div class="hero__container">
		<div class="hero__grid">
			<div class="hero__content" data-animate></div>
		</div>
	</div>

</section>
