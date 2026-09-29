<?php
/**
 * Support / donation CTA.
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);

$donate_url = kenda_home( 'cta_button_url', kenda_site( 'donation_url' ) );
$qr_id      = kenda_home( 'cta_qr_image' );
?>
<section class="section section--cta" id="support" data-animate>
	<div class="section__inner cta-band">
		<div class="cta-band__copy">
			<?php if ( kenda_home( 'cta_eyebrow' ) ) : ?>
				<p class="eyebrow eyebrow--gold"><?php echo esc_html( kenda_home( 'cta_eyebrow' ) ); ?></p>
			<?php endif; ?>
			<?php if ( kenda_home( 'cta_heading' ) ) : ?>
				<h2 class="display-md"><?php echo esc_html( kenda_home( 'cta_heading' ) ); ?></h2>
			<?php endif; ?>
			<?php if ( kenda_home( 'cta_body' ) ) : ?>
				<div class="cta-body"><?php echo kenda_content( (string) kenda_home( 'cta_body' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
			<?php endif; ?>
			<?php if ( kenda_home( 'cta_button_text' ) && $donate_url ) : ?>
				<div class="cta-band__actions">
					<a class="btn btn--donate btn--lg" href="<?php echo esc_url( $donate_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( kenda_home( 'cta_button_text' ) ); ?></a>
				</div>
			<?php endif; ?>
		</div>
		<?php if ( $qr_id ) : ?>
			<div class="cta-band__qr">
				<?php echo kenda_render_image( $qr_id, 'medium', array( 'alt' => __( 'Donate QR code', 'kenda-custom' ) ) ); ?>
			</div>
		<?php endif; ?>
	</div>
</section>
