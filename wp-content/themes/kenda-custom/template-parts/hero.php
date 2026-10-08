<?php
/**
 * Campaign hero — Slide 1 copy from CMS + video + shield.
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);

$video_url   = kenda_media_url( kenda_home( 'hero_video' ), KENDA_THEME_URI . '/assets/videos/hero-campaign.mp4' );
$poster_url  = kenda_media_url( kenda_home( 'hero_poster' ), KENDA_THEME_URI . '/assets/images/kc-skyline.png' );
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
$logo_id     = kenda_custom_logo_id();
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
		<video class="hero__video" playsinline muted loop autoplay preload="metadata" poster="<?php echo esc_url( $poster_url ); ?>" data-hero-video>
			<source src="<?php echo esc_url( $video_url ); ?>" type="video/mp4" />
		</video>
		<!-- <div class="hero__overlay"></div> -->
		<div class="hero__overlay hero__overlay--accent"></div>
	</div>

	<div class="hero__container">
		<div class="hero__grid">
			<div class="hero__content" data-animate>
				<?php if ( '' !== trim( $elect ) ) : ?>
					<p class="hero__elect"><?php echo esc_html( $elect ); ?></p>
				<?php endif; ?>

				<?php if ( $name_parts ) : ?>
					<h1 class="hero__headline hero__headline--stack">
						<?php foreach ( $name_parts as $part ) : ?>
							<span class="hero__name-line"><?php echo esc_html( $part ); ?></span>
						<?php endforeach; ?>
					</h1>
				<?php endif; ?>

				<div class="hero__copy">
					<?php if ( '' !== trim( $subtitle ) ) : ?>
						<?php
						$subtitle_html = esc_html( $subtitle );
						$subtitle_html = preg_replace(
							'/(\s)(Every tax dollar accounted for\.)/i',
							'$1<br>$2',
							$subtitle_html,
							1
						);
						?>
						<p class="hero__lead"><?php echo $subtitle_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above. ?></p>
					<?php endif; ?>

					<?php if ( '' !== trim( $eyebrow ) || '' !== trim( $credit ) || '' !== trim( $services ) ) : ?>
						<div class="hero__meta">
							<?php if ( '' !== trim( $eyebrow ) ) : ?>
								<p class="hero__meta-line hero__meta-line--accent"><?php echo esc_html( $eyebrow ); ?></p>
							<?php endif; ?>
							<?php if ( '' !== trim( $credit ) ) : ?>
								<p class="hero__meta-line hero__meta-line--strong"><?php echo esc_html( $credit ); ?></p>
							<?php endif; ?>
							<?php if ( '' !== trim( $services ) ) : ?>
								<p class="hero__meta-line hero__meta-line--accent"><?php echo esc_html( $services ); ?></p>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if ( '' !== trim( $website ) ) : ?>
						<p class="hero__website">
							<a class="hero__website-link" href="<?php echo esc_url( $website_href ); ?>"><?php echo esc_html( $website ); ?></a>
						</p>
					<?php endif; ?>

					<?php if ( '' !== trim( $desc ) ) : ?>
						<p class="hero__summary"><?php echo esc_html( $desc ); ?></p>
					<?php endif; ?>

					<?php if ( ( $p_text && $p_url ) || ( $s_text && $s_url ) ) : ?>
						<div class="hero__actions">
							<?php if ( $p_text && $p_url ) : ?>
								<a class="btn btn--gold btn--lg js-scroll-link" href="<?php echo esc_url( $p_url ); ?>"><?php echo esc_html( $p_text ); ?></a>
							<?php endif; ?>
							<?php if ( $s_text && $s_url ) : ?>
								<a class="btn btn--outline btn--lg js-scroll-link" href="<?php echo esc_url( $s_url ); ?>"><?php echo esc_html( $s_text ); ?></a>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<div class="hero__brand" data-animate>
				<div class="hero__brand-card">
					<?php
					echo kenda_render_image(
						$logo_id,
						'medium',
						array(
							'class' => 'hero__brand-mark',
							'alt'   => $brand_alt,
						),
						$logo_fb,
						$brand_alt
					);
					?>
				</div>
			</div>
		</div>
	</div>

	<a class="hero__scroll-hint js-scroll-link" href="#intro" aria-label="<?php esc_attr_e( 'Scroll to content', 'kenda-custom' ); ?>">
		<span class="hero__scroll-hint-text"><?php esc_html_e( 'Explore', 'kenda-custom' ); ?></span>
		<span class="hero__scroll-hint-icon" aria-hidden="true"></span>
	</a>
</section>
