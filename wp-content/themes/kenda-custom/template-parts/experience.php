<?php
/**
 * Experience / leadership timeline.
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);

$query = new WP_Query(
	array(
		'post_type'      => 'kenda_experience',
		'posts_per_page' => 20,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'post_status'    => 'publish',
	)
);
?>
<section class="section section--experience section--dark" id="experience" data-animate>
	<div class="section__inner">
		<header class="section-header section-header--ppt">
			<?php if ( kenda_home( 'experience_eyebrow' ) ) : ?>
				<p class="eyebrow eyebrow--gold"><?php echo esc_html( kenda_home( 'experience_eyebrow' ) ); ?></p>
			<?php endif; ?>
			<?php if ( kenda_home( 'experience_heading' ) ) : ?>
				<h2 class="display-md"><?php echo esc_html( kenda_home( 'experience_heading' ) ); ?></h2>
			<?php endif; ?>
			<?php if ( kenda_home( 'experience_intro' ) ) : ?>
				<p class="lead section-header__lead"><?php echo esc_html( kenda_home( 'experience_intro' ) ); ?></p>
			<?php endif; ?>
		</header>
		<?php if ( $query->have_posts() ) : ?>
			<ol class="timeline">
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					$year = get_post_meta( get_the_ID(), 'experience_year', true );
					$org  = get_post_meta( get_the_ID(), 'experience_organization', true );
					?>
					<li class="timeline__item">
						<div class="timeline__year"><?php echo esc_html( (string) $year ); ?></div>
						<div class="timeline__body">
							<h3 class="timeline__title"><?php the_title(); ?></h3>
							<?php if ( $org ) : ?>
								<p class="timeline__org"><?php echo esc_html( (string) $org ); ?></p>
							<?php endif; ?>
							<div class="timeline__text"><?php the_content(); ?></div>
						</div>
					</li>
				<?php endwhile; ?>
			</ol>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
	</div>
</section>
