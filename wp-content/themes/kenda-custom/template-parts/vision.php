<?php
/**
 * Vision editorial section.
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);

$fallback = KENDA_THEME_URI . '/assets/images/kc-community.jpg';
?>
<section class="section section--vision" id="vision" data-animate>
	<div class="section__inner vision-grid">
		<div class="vision-grid__media">
			<?php
			echo kenda_render_image(
				kenda_home( 'vision_image' ),
				'kenda-card',
				array( 'class' => 'vision-grid__image', 'alt' => kenda_home( 'vision_heading', __( 'Kansas City vision', 'kenda-custom' ) ) ),
				$fallback,
				__( 'Kansas City', 'kenda-custom' )
			);
			?>
		</div>
		<div class="vision-grid__content">
			<?php if ( kenda_home( 'vision_eyebrow' ) ) : ?>
				<p class="eyebrow eyebrow--gold"><?php echo esc_html( kenda_home( 'vision_eyebrow' ) ); ?></p>
			<?php endif; ?>
			<?php if ( kenda_home( 'vision_heading' ) ) : ?>
				<h2 class="display-md"><?php echo esc_html( kenda_home( 'vision_heading' ) ); ?></h2>
			<?php endif; ?>
			<?php if ( kenda_home( 'vision_body' ) ) : ?>
				<div class="vision-body"><?php echo kenda_content( (string) kenda_home( 'vision_body' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
			<?php endif; ?>
		</div>
	</div>
</section>
