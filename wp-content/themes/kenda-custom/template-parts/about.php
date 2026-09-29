<?php
/**
 * About section.
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);

$logo_id      = kenda_custom_logo_id();
$fallback_img = KENDA_THEME_URI . '/assets/images/campaign-logo-shield.png';
$facts        = array_filter( array_map( 'trim', explode( "\n", (string) kenda_home( 'about_facts' ) ) ) );
$about_alt    = kenda_site( 'site_name', __( 'Kenda Tomes McClain 4 KC', 'kenda-custom' ) );
?>
<section class="section section--about" id="about" data-animate>
	<div class="section__inner about">
		<div class="about__layout">
			<div class="about__brand" aria-hidden="false">
				<figure class="about__logo">
					<?php
					echo kenda_render_image(
						$logo_id,
						'full',
						array(
							'class' => 'about__logo-img',
							'alt'   => $about_alt,
						),
						$fallback_img,
						$about_alt
					);
					?>
				</figure>
			</div>

			<div class="about__content">
				<?php if ( kenda_home( 'about_eyebrow' ) ) : ?>
					<p class="eyebrow about__eyebrow"><?php echo esc_html( kenda_home( 'about_eyebrow' ) ); ?></p>
				<?php endif; ?>
				<?php if ( kenda_home( 'about_heading' ) ) : ?>
					<h2 class="display-md about__heading"><?php echo esc_html( kenda_home( 'about_heading' ) ); ?></h2>
				<?php endif; ?>
				<?php if ( kenda_home( 'about_body' ) ) : ?>
					<div class="about__body"><?php echo kenda_content( (string) kenda_home( 'about_body' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
				<?php endif; ?>

				<?php if ( $facts ) : ?>
					<ul class="about__highlights">
						<?php foreach ( $facts as $fact ) : ?>
							<li class="about__highlight"><?php echo esc_html( $fact ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
