<?php
/**
 * Platform priorities with expandable cards.
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);

$query = new WP_Query(
	array(
		'post_type'      => 'kenda_priority',
		'posts_per_page' => 12,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'post_status'    => 'publish',
	)
);
?>
<section class="section section--priorities" id="priorities" data-animate>
	<div class="section__inner">
		<header class="section-header section-header--ppt">
			<?php if ( kenda_home( 'priorities_eyebrow' ) ) : ?>
				<p class="eyebrow"><?php echo esc_html( kenda_home( 'priorities_eyebrow' ) ); ?></p>
			<?php endif; ?>
			<?php if ( kenda_home( 'priorities_heading' ) ) : ?>
				<h2 class="display-md"><?php echo esc_html( kenda_home( 'priorities_heading' ) ); ?></h2>
			<?php endif; ?>
			<?php if ( kenda_home( 'priorities_intro' ) ) : ?>
				<p class="lead section-header__lead"><?php echo esc_html( kenda_home( 'priorities_intro' ) ); ?></p>
			<?php endif; ?>
		</header>
		<?php if ( $query->have_posts() ) : ?>
			<div class="priority-grid" data-priority-accordion>
				<?php
				$i = 0;
				while ( $query->have_posts() ) :
					$query->the_post();
					$num   = get_post_meta( get_the_ID(), 'priority_number', true );
					$short = get_post_meta( get_the_ID(), 'priority_short_description', true );
					if ( ! $num ) {
						$num = sprintf( '%02d', $i + 1 );
					}
					$panel_id = 'priority-panel-' . get_the_ID();
					?>
					<article class="priority-card">
						<button type="button" class="priority-card__toggle" aria-expanded="false" aria-controls="<?php echo esc_attr( $panel_id ); ?>" data-priority-toggle>
							<span class="priority-card__num"><?php echo esc_html( (string) $num ); ?></span>
							<span class="priority-card__head">
								<span class="priority-card__title"><?php the_title(); ?></span>
								<?php if ( $short ) : ?>
									<span class="priority-card__short"><?php echo esc_html( (string) $short ); ?></span>
								<?php endif; ?>
							</span>
							<span class="priority-card__icon" aria-hidden="true"></span>
						</button>
						<div class="priority-card__panel" id="<?php echo esc_attr( $panel_id ); ?>" hidden>
							<div class="priority-card__content"><?php the_content(); ?></div>
						</div>
					</article>
					<?php
					++$i;
				endwhile;
				?>
			</div>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
	</div>
</section>
