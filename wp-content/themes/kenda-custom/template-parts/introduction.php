<?php
/**
 * Introduction band after hero.
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);
?>
<section class="section section--intro" id="intro" data-animate aria-labelledby="intro-heading">
	<div class="section__inner intro-split">
		<div>
			<?php if ( kenda_home( 'intro_eyebrow' ) ) : ?>
				<p class="eyebrow"><?php echo esc_html( kenda_home( 'intro_eyebrow' ) ); ?></p>
			<?php endif; ?>
			<?php if ( kenda_home( 'intro_heading' ) ) : ?>
				<h2 class="display-md" id="intro-heading"><?php echo esc_html( kenda_home( 'intro_heading' ) ); ?></h2>
			<?php endif; ?>
		</div>
		<div class="intro-copy">
			<?php if ( kenda_home( 'intro_lead' ) ) : ?>
				<p class="lead"><?php echo esc_html( kenda_home( 'intro_lead' ) ); ?></p>
			<?php endif; ?>
			<?php if ( kenda_home( 'intro_body' ) ) : ?>
				<p><?php echo esc_html( kenda_home( 'intro_body' ) ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>
