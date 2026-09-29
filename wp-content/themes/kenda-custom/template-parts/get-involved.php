<?php
/**
 * Community / volunteer section.
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);
?>
<section class="section section--involved section--dark" id="get-involved" data-animate>
	<div class="section__inner involved-layout">
		<div>
			<?php if ( kenda_home( 'involved_eyebrow' ) ) : ?>
				<p class="eyebrow eyebrow--gold"><?php echo esc_html( kenda_home( 'involved_eyebrow' ) ); ?></p>
			<?php endif; ?>
			<?php if ( kenda_home( 'involved_heading' ) ) : ?>
				<h2 class="display-md"><?php echo esc_html( kenda_home( 'involved_heading' ) ); ?></h2>
			<?php endif; ?>
		</div>
		<div>
			<?php if ( kenda_home( 'involved_body' ) ) : ?>
				<p class="lead"><?php echo esc_html( kenda_home( 'involved_body' ) ); ?></p>
			<?php endif; ?>
			<?php if ( kenda_home( 'involved_cta_text' ) && kenda_home( 'involved_cta_url' ) ) : ?>
				<div class="involved-actions">
					<a class="btn btn--gold btn--lg js-scroll-link" href="<?php echo esc_url( kenda_home( 'involved_cta_url' ) ); ?>"><?php echo esc_html( kenda_home( 'involved_cta_text' ) ); ?></a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
