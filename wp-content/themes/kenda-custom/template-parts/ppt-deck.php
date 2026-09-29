<?php
/**
 * PPT slides 2–14 (Slide 1 = hero).
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);

$s02_bullets  = kenda_ppt_lines( (string) kenda_ppt( 'slide_02', 'bullets', '' ) );
$s02_scope    = kenda_ppt_lines( (string) kenda_ppt( 'slide_02', 'scope_bullets', '' ) );
$s03_cards    = kenda_ppt( 'slide_03', 'cards', array() );
$s04_steps    = kenda_ppt( 'slide_04', 'steps', array() );
$s05_bullets  = kenda_ppt_lines( (string) kenda_ppt( 'slide_05', 'bullets', '' ) );
$s08_includes = kenda_ppt_lines( (string) kenda_ppt( 'slide_08', 'includes', '' ) );
$s08_opt      = kenda_ppt_lines( (string) kenda_ppt( 'slide_08', 'optimized', '' ) );
$s09_logos    = kenda_ppt( 'slide_09', 'logos', array() );
$s10_services = kenda_ppt( 'slide_10', 'services', array() );
$s12_payments = kenda_ppt( 'slide_12', 'payments', array() );
$s13_bullets  = kenda_ppt_lines( (string) kenda_ppt( 'slide_13', 'bullets', '' ) );

$priority_query = new WP_Query(
	array(
		'post_type'      => 'kenda_priority',
		'posts_per_page' => 3,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'post_status'    => 'publish',
	)
);

$experience_query = new WP_Query(
	array(
		'post_type'      => 'kenda_experience',
		'posts_per_page' => 20,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'post_status'    => 'publish',
	)
);

$timeline_phases = kenda_ppt( 'slide_11', 'phases', array() );
$s07_table       = kenda_ppt( 'slide_07', 'table', array() );
?>

<!-- Slide 2 -->
<section class="ppt-slide ppt-slide--02" id="intro" data-animate aria-labelledby="ppt-slide-02-title">
	<div class="ppt-slide__bar" aria-hidden="true"></div>
	<div class="ppt-slide__inner">
		<p class="ppt-slide__eyebrow"><?php echo esc_html( (string) kenda_ppt( 'slide_02', 'eyebrow' ) ); ?></p>
		<h2 class="ppt-slide__title" id="ppt-slide-02-title"><?php echo esc_html( (string) kenda_ppt( 'slide_02', 'heading' ) ); ?></h2>
		<p class="ppt-slide__lead"><?php echo esc_html( (string) kenda_ppt( 'slide_02', 'intro' ) ); ?></p>
		<div class="ppt-slide__cols ppt-slide__cols--02">
			<ul class="ppt-slide__bullets">
				<?php foreach ( $s02_bullets as $line ) : ?>
					<li><?php echo esc_html( $line ); ?></li>
				<?php endforeach; ?>
			</ul>
			<aside class="ppt-slide__scope">
				<h3 class="ppt-slide__scope-title"><?php echo esc_html( (string) kenda_ppt( 'slide_02', 'scope_title' ) ); ?></h3>
				<ul class="ppt-slide__bullets ppt-slide__bullets--compact">
					<?php foreach ( $s02_scope as $line ) : ?>
						<li><?php echo esc_html( $line ); ?></li>
					<?php endforeach; ?>
				</ul>
			</aside>
		</div>
	</div>
</section>

<!-- Slide 3 -->
<section class="ppt-slide ppt-slide--03" data-animate aria-labelledby="ppt-slide-03-title">
	<div class="ppt-slide__bar" aria-hidden="true"></div>
	<div class="ppt-slide__inner">
		<h2 class="ppt-slide__title" id="ppt-slide-03-title"><?php echo esc_html( (string) kenda_ppt( 'slide_03', 'heading' ) ); ?></h2>
		<p class="ppt-slide__sub"><?php echo esc_html( (string) kenda_ppt( 'slide_03', 'subheading' ) ); ?></p>
		<p class="ppt-slide__stat"><?php echo esc_html( (string) kenda_ppt( 'slide_03', 'stat' ) ); ?></p>
		<p class="ppt-slide__tags"><?php echo esc_html( (string) kenda_ppt( 'slide_03', 'tags' ) ); ?></p>
		<?php if ( is_array( $s03_cards ) && $s03_cards ) : ?>
			<div class="ppt-card-grid ppt-card-grid--8">
				<?php foreach ( $s03_cards as $card ) : ?>
					<?php if ( ! is_array( $card ) ) { continue; } ?>
					<article class="ppt-card">
						<h3 class="ppt-card__title"><?php echo esc_html( (string) ( $card['title'] ?? '' ) ); ?></h3>
						<?php if ( ! empty( $card['desc'] ) ) : ?>
							<p class="ppt-card__desc"><?php echo esc_html( (string) $card['desc'] ); ?></p>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<!-- Slide 4 -->
<section class="ppt-slide ppt-slide--04" data-animate aria-labelledby="ppt-slide-04-title">
	<div class="ppt-slide__bar" aria-hidden="true"></div>
	<div class="ppt-slide__inner">
		<div class="ppt-slide__head-row">
			<h2 class="ppt-slide__title ppt-slide__title--inline" id="ppt-slide-04-title"><?php echo esc_html( (string) kenda_ppt( 'slide_04', 'heading' ) ); ?></h2>
			<span class="ppt-slide__arrow" aria-hidden="true">→</span>
			<p class="ppt-slide__title-accent"><?php echo esc_html( (string) kenda_ppt( 'slide_04', 'arrow_title' ) ); ?></p>
		</div>
		<p class="ppt-slide__lead"><?php echo esc_html( (string) kenda_ppt( 'slide_04', 'lead' ) ); ?></p>
		<?php if ( is_array( $s04_steps ) && $s04_steps ) : ?>
			<ol class="ppt-steps ppt-steps--4">
				<?php foreach ( $s04_steps as $step ) : ?>
					<?php if ( ! is_array( $step ) ) { continue; } ?>
					<li class="ppt-step">
						<span class="ppt-step__num"><?php echo esc_html( (string) ( $step['num'] ?? '' ) ); ?></span>
						<h3 class="ppt-step__title"><?php echo esc_html( (string) ( $step['title'] ?? '' ) ); ?></h3>
						<?php
						$desc_lines = kenda_ppt_lines( (string) ( $step['desc'] ?? '' ) );
						foreach ( $desc_lines as $line ) :
							?>
							<p class="ppt-step__line"><?php echo esc_html( $line ); ?></p>
						<?php endforeach; ?>
					</li>
				<?php endforeach; ?>
			</ol>
		<?php endif; ?>
	</div>
</section>

<!-- Slide 5 -->
<section class="ppt-slide ppt-slide--05 ppt-slide--dark" id="vision" data-animate aria-labelledby="ppt-slide-05-title">
	<div class="ppt-slide__bar" aria-hidden="true"></div>
	<div class="ppt-slide__inner">
		<h2 class="ppt-slide__title ppt-slide__title--light" id="ppt-slide-05-title"><?php echo esc_html( (string) kenda_ppt( 'slide_05', 'heading' ) ); ?></h2>
		<p class="ppt-slide__sub ppt-slide__sub--light"><?php echo esc_html( (string) kenda_ppt( 'slide_05', 'subheading' ) ); ?></p>
		<ul class="ppt-slide__bullets ppt-slide__bullets--light">
			<?php foreach ( $s05_bullets as $line ) : ?>
				<li><?php echo esc_html( $line ); ?></li>
			<?php endforeach; ?>
		</ul>
		<div class="ppt-formula">
			<p class="ppt-formula__label"><?php echo esc_html( (string) kenda_ppt( 'slide_05', 'formula_label' ) ); ?></p>
			<p class="ppt-formula__text"><?php echo esc_html( (string) kenda_ppt( 'slide_05', 'formula_text' ) ); ?></p>
		</div>
		<div class="ppt-objective">
			<p class="ppt-objective__label"><?php echo esc_html( (string) kenda_ppt( 'slide_05', 'objective_label' ) ); ?></p>
			<p class="ppt-objective__text"><?php echo esc_html( (string) kenda_ppt( 'slide_05', 'objective_text' ) ); ?></p>
		</div>
	</div>
</section>

<!-- Slide 6 -->
<section class="ppt-slide ppt-slide--06" id="about" data-animate aria-labelledby="ppt-slide-06-title">
	<div class="ppt-slide__bar" aria-hidden="true"></div>
	<div class="ppt-slide__inner">
		<h2 class="ppt-slide__title" id="ppt-slide-06-title"><?php echo esc_html( kenda_home( 'about_heading', __( "The Candidate's Story", 'kenda-custom' ) ) ); ?></h2>
		<p class="ppt-slide__sub"><?php echo esc_html( kenda_home( 'experience_intro', __( '30+ years in finance and civic leadership', 'kenda-custom' ) ) ); ?></p>
		<div class="ppt-slide__cols ppt-slide__cols--06">
			<div class="ppt-story">
				<?php if ( kenda_home( 'about_eyebrow' ) ) : ?>
					<p class="ppt-slide__eyebrow"><?php echo esc_html( kenda_home( 'about_eyebrow' ) ); ?></p>
				<?php endif; ?>
				<?php if ( kenda_home( 'about_body' ) ) : ?>
					<div class="ppt-story__body"><?php echo kenda_content( (string) kenda_home( 'about_body' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
				<?php endif; ?>
			</div>
			<?php if ( $priority_query->have_posts() ) : ?>
				<div class="ppt-pillar-stack">
					<?php
					while ( $priority_query->have_posts() ) :
						$priority_query->the_post();
						$short = get_post_meta( get_the_ID(), 'priority_short_description', true );
						?>
						<article class="ppt-pillar-card">
							<h3 class="ppt-pillar-card__title"><?php the_title(); ?></h3>
							<p class="ppt-pillar-card__desc"><?php echo esc_html( $short ? (string) $short : wp_strip_all_tags( get_the_content() ) ); ?></p>
						</article>
					<?php endwhile; ?>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>
	</div>
</section>

<!-- Slide 7 -->
<section class="ppt-slide ppt-slide--07" id="priorities" data-animate aria-labelledby="ppt-slide-07-title">
	<div class="ppt-slide__bar" aria-hidden="true"></div>
	<div class="ppt-slide__inner">
		<h2 class="ppt-slide__title" id="ppt-slide-07-title"><?php echo esc_html( kenda_home( 'priorities_heading', __( 'Sentiment Analysis: What Greater Kansas City Thinks', 'kenda-custom' ) ) ); ?></h2>
		<p class="ppt-slide__sub"><?php echo esc_html( kenda_home( 'priorities_intro', __( 'Measure Kenda’s three pillars by zip code, generation, and issue intensity', 'kenda-custom' ) ) ); ?></p>
		<?php if ( kenda_ppt( 'slide_07', 'deliverable' ) ) : ?>
			<p class="ppt-slide__deliverable"><?php echo esc_html( (string) kenda_ppt( 'slide_07', 'deliverable' ) ); ?></p>
		<?php endif; ?>
		<div class="ppt-table-wrap">
			<table class="ppt-table">
				<thead>
					<tr>
						<th scope="col"><?php esc_html_e( 'Pillar', 'kenda-custom' ); ?></th>
						<th scope="col"><?php esc_html_e( 'What We Measure', 'kenda-custom' ); ?></th>
						<th scope="col"><?php esc_html_e( 'How It Shapes the Message', 'kenda-custom' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php if ( is_array( $s07_table ) ) : ?>
						<?php foreach ( $s07_table as $row ) : ?>
							<?php if ( ! is_array( $row ) ) { continue; } ?>
							<tr>
								<th scope="row"><?php echo esc_html( (string) ( $row['pillar'] ?? '' ) ); ?></th>
								<td><?php echo esc_html( (string) ( $row['measure'] ?? '' ) ); ?></td>
								<td><?php echo esc_html( (string) ( $row['message'] ?? '' ) ); ?></td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</section>

<!-- Slide 8 -->
<section class="ppt-slide ppt-slide--08" id="get-involved" data-animate aria-labelledby="ppt-slide-08-title">
	<div class="ppt-slide__bar" aria-hidden="true"></div>
	<div class="ppt-slide__inner">
		<h2 class="ppt-slide__title" id="ppt-slide-08-title"><?php echo esc_html( (string) kenda_ppt( 'slide_08', 'heading' ) ); ?></h2>
		<p class="ppt-slide__strategy"><span><?php echo esc_html( (string) kenda_ppt( 'slide_08', 'strategy' ) ); ?></span> <?php echo esc_html( (string) kenda_ppt( 'slide_08', 'stat' ) ); ?></p>
		<p class="ppt-slide__lead"><?php echo esc_html( (string) kenda_ppt( 'slide_08', 'lead' ) ); ?></p>
		<div class="ppt-taglines">
			<?php foreach ( kenda_ppt( 'slide_08', 'taglines', array() ) as $tag ) : ?>
				<span class="ppt-tagline"><?php echo esc_html( (string) $tag ); ?></span>
			<?php endforeach; ?>
		</div>
		<div class="ppt-slide__cols ppt-slide__cols--08">
			<div>
				<h3 class="ppt-slide__h3"><?php esc_html_e( 'What is included', 'kenda-custom' ); ?></h3>
				<ul class="ppt-slide__bullets">
					<?php foreach ( $s08_includes as $line ) : ?>
						<li><?php echo esc_html( $line ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="ppt-slide__panel">
				<h3 class="ppt-slide__h3"><?php echo esc_html( (string) kenda_ppt( 'slide_08', 'opt_title' ) ); ?></h3>
				<p class="ppt-slide__panel-label"><?php echo esc_html( (string) kenda_ppt( 'slide_08', 'human' ) ); ?></p>
				<ul class="ppt-slide__bullets ppt-slide__bullets--compact">
					<?php foreach ( $s08_opt as $line ) : ?>
						<li><?php echo esc_html( $line ); ?></li>
					<?php endforeach; ?>
				</ul>
				<?php if ( kenda_home( 'involved_cta_text' ) && kenda_home( 'involved_cta_url' ) ) : ?>
					<a class="btn btn--gold js-scroll-link" href="<?php echo esc_url( kenda_home( 'involved_cta_url', '#contact' ) ); ?>"><?php echo esc_html( kenda_home( 'involved_cta_text' ) ); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<!-- Slide 9 -->
<section class="ppt-slide ppt-slide--09" data-animate aria-labelledby="ppt-slide-09-title">
	<div class="ppt-slide__bar" aria-hidden="true"></div>
	<div class="ppt-slide__inner">
		<h2 class="ppt-slide__title" id="ppt-slide-09-title"><?php echo esc_html( (string) kenda_ppt( 'slide_09', 'heading' ) ); ?></h2>
		<p class="ppt-slide__sub"><?php echo esc_html( (string) kenda_ppt( 'slide_09', 'subheading' ) ); ?></p>
		<p class="ppt-slide__eyebrow"><?php echo esc_html( (string) kenda_ppt( 'slide_09', 'logos_label' ) ); ?></p>
		<div class="ppt-logo-chips">
			<?php foreach ( $s09_logos as $logo ) : ?>
				<span class="ppt-logo-chip"><?php echo esc_html( (string) $logo ); ?></span>
			<?php endforeach; ?>
		</div>
		<div class="ppt-feature-cols">
			<div class="ppt-feature">
				<h3 class="ppt-feature__title"><?php echo esc_html( (string) kenda_ppt( 'slide_09', 'target_title' ) ); ?></h3>
				<ul class="ppt-slide__bullets ppt-slide__bullets--compact">
					<?php foreach ( kenda_ppt_lines( (string) kenda_ppt( 'slide_09', 'target', '' ) ) as $line ) : ?>
						<li><?php echo esc_html( $line ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="ppt-feature">
				<h3 class="ppt-feature__title"><?php echo esc_html( (string) kenda_ppt( 'slide_09', 'attrib_title' ) ); ?></h3>
				<ul class="ppt-slide__bullets ppt-slide__bullets--compact">
					<?php foreach ( kenda_ppt_lines( (string) kenda_ppt( 'slide_09', 'attrib', '' ) ) as $line ) : ?>
						<li><?php echo esc_html( $line ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="ppt-feature">
				<h3 class="ppt-feature__title"><?php echo esc_html( (string) kenda_ppt( 'slide_09', 'video_title' ) ); ?></h3>
				<ul class="ppt-slide__bullets ppt-slide__bullets--compact">
					<?php foreach ( kenda_ppt_lines( (string) kenda_ppt( 'slide_09', 'video', '' ) ) as $line ) : ?>
						<li><?php echo esc_html( $line ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</section>

<!-- Slide 10 -->
<section class="ppt-slide ppt-slide--10" data-animate aria-labelledby="ppt-slide-10-title">
	<div class="ppt-slide__bar" aria-hidden="true"></div>
	<div class="ppt-slide__inner">
		<h2 class="ppt-slide__title" id="ppt-slide-10-title"><?php echo esc_html( (string) kenda_ppt( 'slide_10', 'heading' ) ); ?></h2>
		<p class="ppt-slide__sub"><?php echo esc_html( (string) kenda_ppt( 'slide_10', 'subheading' ) ); ?></p>
		<?php if ( is_array( $s10_services ) && $s10_services ) : ?>
			<div class="ppt-service-grid">
				<?php foreach ( $s10_services as $service ) : ?>
					<?php if ( ! is_array( $service ) ) { continue; } ?>
					<article class="ppt-service">
						<span class="ppt-service__num"><?php echo esc_html( (string) ( $service['num'] ?? '' ) ); ?>.</span>
						<h3 class="ppt-service__title"><?php echo esc_html( (string) ( $service['title'] ?? '' ) ); ?></h3>
						<p class="ppt-service__desc"><?php echo esc_html( (string) ( $service['desc'] ?? '' ) ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<!-- Slide 11 -->
<section class="ppt-slide ppt-slide--11" id="experience" data-animate aria-labelledby="ppt-slide-11-title">
	<div class="ppt-slide__bar" aria-hidden="true"></div>
	<div class="ppt-slide__inner">
		<h2 class="ppt-slide__title" id="ppt-slide-11-title"><?php echo esc_html( (string) kenda_ppt( 'slide_11', 'heading', __( 'Service Delivery Timeline', 'kenda-custom' ) ) ); ?></h2>
		<p class="ppt-slide__sub"><?php echo esc_html( (string) kenda_ppt( 'slide_11', 'subheading', '' ) ); ?></p>
		<ol class="ppt-timeline">
			<?php foreach ( is_array( $timeline_phases ) ? $timeline_phases : array() as $phase ) : ?>
				<li class="ppt-timeline__item">
					<span class="ppt-timeline__num"><?php echo esc_html( (string) $phase['num'] ); ?></span>
					<div class="ppt-timeline__body">
						<p class="ppt-timeline__period"><?php echo esc_html( (string) $phase['period'] ); ?></p>
						<h3 class="ppt-timeline__title"><?php echo esc_html( (string) $phase['title'] ); ?></h3>
						<p class="ppt-timeline__desc"><?php echo esc_html( (string) $phase['desc'] ); ?></p>
					</div>
				</li>
			<?php endforeach; ?>
		</ol>
		<?php if ( $experience_query->have_posts() ) : ?>
			<div class="ppt-resume">
				<h3 class="ppt-slide__h3"><?php echo esc_html( kenda_home( 'experience_heading', __( 'Leadership & Experience', 'kenda-custom' ) ) ); ?></h3>
				<ol class="timeline timeline--ppt">
					<?php
					while ( $experience_query->have_posts() ) :
						$experience_query->the_post();
						$year = get_post_meta( get_the_ID(), 'experience_year', true );
						$org  = get_post_meta( get_the_ID(), 'experience_organization', true );
						?>
						<li class="timeline__item">
							<div class="timeline__year"><?php echo esc_html( (string) $year ); ?></div>
							<div class="timeline__body">
								<h4 class="timeline__title"><?php the_title(); ?></h4>
								<?php if ( $org ) : ?>
									<p class="timeline__org"><?php echo esc_html( (string) $org ); ?></p>
								<?php endif; ?>
								<div class="timeline__text"><?php the_content(); ?></div>
							</div>
						</li>
					<?php endwhile; ?>
				</ol>
				<?php wp_reset_postdata(); ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<!-- Slide 12 -->
<section class="ppt-slide ppt-slide--12" id="support" data-animate aria-labelledby="ppt-slide-12-title">
	<div class="ppt-slide__bar" aria-hidden="true"></div>
	<div class="ppt-slide__inner">
		<h2 class="ppt-slide__title" id="ppt-slide-12-title"><?php echo esc_html( kenda_home( 'cta_heading', (string) kenda_ppt( 'slide_12', 'heading' ) ) ); ?></h2>
		<p class="ppt-slide__sub"><?php echo esc_html( (string) kenda_ppt( 'slide_12', 'subheading' ) ); ?></p>
		<div class="ppt-payment-grid">
			<?php foreach ( $s12_payments as $payment ) : ?>
				<?php if ( ! is_array( $payment ) ) { continue; } ?>
				<article class="ppt-payment">
					<h3 class="ppt-payment__label"><?php echo esc_html( (string) ( $payment['label'] ?? '' ) ); ?></h3>
					<p class="ppt-payment__amount"><?php echo esc_html( (string) ( $payment['amount'] ?? '' ) ); ?></p>
					<p class="ppt-payment__note"><?php echo esc_html( (string) ( $payment['note'] ?? '' ) ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
		<p class="ppt-payment-total"><?php echo esc_html( (string) kenda_ppt( 'slide_12', 'total' ) ); ?></p>
		<p class="ppt-payment-total-label"><?php echo esc_html( (string) kenda_ppt( 'slide_12', 'total_label' ) ); ?></p>
		<p class="ppt-slide__quote"><?php echo esc_html( (string) kenda_ppt( 'slide_12', 'quote' ) ); ?></p>
		<?php if ( kenda_home( 'cta_button_text' ) && kenda_home( 'cta_button_url', kenda_site( 'donation_url' ) ) ) : ?>
			<a class="btn btn--donate btn--lg" href="<?php echo esc_url( kenda_home( 'cta_button_url', kenda_site( 'donation_url' ) ) ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( kenda_home( 'cta_button_text' ) ); ?></a>
		<?php endif; ?>
		<p class="ppt-slide__fine"><?php echo esc_html( (string) kenda_ppt( 'slide_12', 'disclaimer' ) ); ?></p>
	</div>
</section>

<!-- Slide 13 -->
<section class="ppt-slide ppt-slide--13 ppt-slide--ice" data-animate aria-labelledby="ppt-slide-13-title">
	<div class="ppt-slide__bar" aria-hidden="true"></div>
	<div class="ppt-slide__inner">
		<h2 class="ppt-slide__title" id="ppt-slide-13-title"><?php echo esc_html( (string) kenda_ppt( 'slide_13', 'heading' ) ); ?></h2>
		<p class="ppt-slide__sub"><?php echo esc_html( (string) kenda_ppt( 'slide_13', 'subheading' ) ); ?></p>
		<p class="ppt-slide__lead"><?php echo esc_html( (string) kenda_ppt( 'slide_13', 'intro' ) ); ?></p>
		<ul class="ppt-slide__bullets">
			<?php foreach ( $s13_bullets as $line ) : ?>
				<li><?php echo esc_html( $line ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<!-- Slide 14 -->
<section class="ppt-slide ppt-slide--14 ppt-slide--dark" data-animate aria-labelledby="ppt-slide-14-title">
	<div class="ppt-slide__bar" aria-hidden="true"></div>
	<div class="ppt-slide__inner ppt-slide__inner--center">
		<h2 class="ppt-slide__title ppt-slide__title--light" id="ppt-slide-14-title"><?php echo esc_html( (string) kenda_ppt( 'slide_14', 'heading' ) ); ?></h2>
		<p class="ppt-slide__sub ppt-slide__sub--light"><?php echo esc_html( (string) kenda_ppt( 'slide_14', 'subheading' ) ); ?></p>
		<?php
		$closing_lines = array(
			'line_1' => '',
			'line_2' => ' ppt-closing__line--gold',
			'line_3' => '',
			'line_4' => ' ppt-closing__url',
			'line_5' => ' ppt-closing__line--small',
		);
		foreach ( $closing_lines as $key => $class_extra ) :
			$line = trim( (string) kenda_ppt( 'slide_14', $key, '' ) );
			if ( '' === $line ) {
				continue;
			}
			$tag = 'line_4' === $key ? 'p' : 'p';
			$class = 'ppt-closing__line' . $class_extra;
			if ( 'line_4' === $key ) {
				$class = trim( $class_extra );
			}
			printf( '<%1$s class="%2$s">%3$s</%1$s>', $tag, esc_attr( $class ), esc_html( $line ) );
		endforeach;
		?>
		<p class="ppt-closing__thanks"><?php echo esc_html( (string) kenda_ppt( 'slide_14', 'thank_you' ) ); ?></p>
	</div>
</section>
