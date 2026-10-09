<?php
/**
 * All deck content (slides 2–14) — dynamic website layout (not PPT chrome).
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);

$s02_bullets = kenda_ppt_lines(
    kenda_ppt( 'slide_02', 'bullets', '' )
);

$s02_scope = kenda_ppt_lines(
    kenda_ppt( 'slide_02', 'scope_bullets', '' )
);

$logo_fb     = KENDA_THEME_URI . '/assets/images/campaign-logo-shield.png';
$logo_id = (int) kenda_home( 'hero_poster', 0 );
$brand_alt   = kenda_site( 'site_name', __( 'Kenda Tomes McClain', 'kenda-custom' ) );
$s03_cards    = kenda_ppt( 'slide_03', 'cards', array() );
$s04_steps    = kenda_ppt( 'slide_04', 'steps', array() );
$s05_bullets  = kenda_ppt_lines( (string) kenda_ppt( 'slide_05', 'bullets', '' ) );
$s08_includes = kenda_ppt_lines( (string) kenda_ppt( 'slide_08', 'includes', '' ) );
$opt_content = kenda_ppt_lines( (string) kenda_ppt( 'slide_08', 'opt_content', '' ) );
$s08_opt      = kenda_ppt_lines( (string) kenda_ppt( 'slide_08', 'optimized', '' ) );
$s09_logos    = kenda_ppt( 'slide_09', 'logos', array() );
$s10_services = kenda_ppt( 'slide_10', 'services', array() );
$s12_payments = kenda_ppt( 'slide_12', 'payments', array() );
$s13_bullets  = kenda_ppt_lines( (string) kenda_ppt( 'slide_13', 'bullets', '' ) );
$s07_table    = kenda_ppt( 'slide_07', 'table', array() );
$timeline     = kenda_ppt( 'slide_11', 'phases', array() );
$title       = (string) kenda_home( 'hero_title' );


$pillar_preview_query = new WP_Query(
	array(
		'post_type'      => 'kenda_priority',
		'posts_per_page' => 3,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'post_status'    => 'publish',
	)
);

$priority_full_query = new WP_Query(
	array(
		'post_type'      => 'kenda_priority',
		'posts_per_page' => 12,
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

$elect       = (string) kenda_home( 'hero_elect', 'ELECT' );
$words = preg_split( '/\s+/', trim( $title ) );

$name_parts = array(
    implode( ' ', array_slice( $words, 0, 2 ) ),
    implode( ' ', array_slice( $words, 2, 3 ) ),
    implode( ' ', array_slice( $words, 5, 2 ) ),
    implode( ' ', array_slice( $words, 7 ) ),
);
?>

<!-- Slide 3 -->
<section class="k-section" data-animate>

    <div class="k-section__inner">

        <!-- Campaign Introduction -->
		<div class="k-campaign-intro">

			<!-- Left: Content -->
			<div class="k-campaign-intro__content">
				<div class="k-campaign-intro__headline-wrap" data-animate>
					<?php if ( '' !== trim( $elect ) ) : ?>
						<p class="k-campaign-intro__eyebrow"><?php echo esc_html( $elect ); ?></p>
					<?php endif; ?>

					<?php if ( $name_parts ) : ?>
						<h1 class="k-campaign-intro__headline">

							<?php
							$total_parts = count( $name_parts );

							foreach ( $name_parts as $index => $part ) :
								// Skip the last two parts; they are rendered together below.
								if ( $index >= $total_parts - 2 ) {
									continue;
								}
								?>
								<span class="k-campaign-intro__line">
									<?php echo esc_html( $part ); ?>
								</span>
							<?php endforeach; ?>

							<?php if ( $total_parts >= 2 ) : ?>
								<span class="k-campaign-intro__line">
									<?php echo esc_html( $name_parts[ $total_parts - 2 ] ); ?>
									<span class="k-campaign-intro__accent"><?php echo esc_html( $name_parts[ $total_parts - 1 ] ); ?></span>
								</span>
							<?php endif; ?>

						</h1>
					<?php endif; ?>
				</div>

				<p class="k-campaign-intro__tagline">
					<?php echo esc_html( (string) kenda_ppt( 'slide_03', 'tagline_1' ) ); ?>
					<br>
					<?php echo esc_html( (string) kenda_ppt( 'slide_03', 'tagline_2' ) ); ?>
				</p>

				<span class="k-campaign-intro__rule" aria-hidden="true"></span>

				<h2 class="k-campaign-intro__name">
					<?php echo esc_html( (string) kenda_ppt( 'slide_03', 'intro_name' ) ); ?>
				</h2>

				<p class="k-campaign-intro__text">
					<?php echo esc_html( (string) kenda_ppt( 'slide_03', 'intro_text' ) ); ?>
				</p>

				<div class="k-campaign-intro__actions">

					<a
						href="<?php echo esc_url( (string) kenda_ppt( 'slide_03', 'donate_url' ) ); ?>"
						class="k-campaign-intro__btn k-campaign-intro__btn--donate"
					>
						<?php echo esc_html( (string) kenda_ppt( 'slide_03', 'donate_text' ) ); ?>
					</a>

					<a
						href="<?php echo esc_url( (string) kenda_ppt( 'slide_03', 'join_url' ) ); ?>"
						class="k-campaign-intro__btn k-campaign-intro__btn--join"
					>
						<?php echo esc_html( (string) kenda_ppt( 'slide_03', 'join_text' ) ); ?>
					</a>

					<a
						href="<?php echo esc_url( (string) kenda_ppt( 'slide_03', 'updates_url' ) ); ?>"
						class="k-campaign-intro__btn k-campaign-intro__btn--updates"
					>
						<?php echo esc_html( (string) kenda_ppt( 'slide_03', 'updates_text' ) ); ?>
					</a>

				</div>

				<a
					href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', (string) kenda_ppt( 'slide_03', 'phone' ) ) ); ?>"
					class="k-campaign-intro__phone"
				>
					<?php echo esc_html( (string) kenda_ppt( 'slide_03', 'phone' ) ); ?>
				</a>

			</div>

			<!-- Right: Kenda Image -->
			<div class="k-campaign-intro__image">
				<div class="hero__brand-card">
					<?php
					echo kenda_render_image(
						$logo_id,
						'large',
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

        <!-- Existing Slide 3 Content -->
        <header class="k-section__head">

            <h2 class="display-md">
                <?php echo esc_html( (string) kenda_ppt( 'slide_03', 'heading' ) ); ?>
            </h2>

            <p class="k-section__lead">
                <?php echo esc_html( (string) kenda_ppt( 'slide_03', 'subheading' ) ); ?>
            </p>

            <p class="k-stat">
                <?php echo esc_html( (string) kenda_ppt( 'slide_03', 'stat' ) ); ?>
            </p>

            <p class="k-tags">
                <?php echo esc_html( (string) kenda_ppt( 'slide_03', 'tags' ) ); ?>
            </p>

        </header>

        <!-- Existing cards intentionally disabled -->
        <!--
        <?php if ( is_array( $s03_cards ) && $s03_cards ) : ?>

            <div class="k-card-grid k-card-grid--4">

                <?php foreach ( $s03_cards as $card ) : ?>

                    <?php if ( ! is_array( $card ) ) {
                        continue;
                    } ?>

                    <article class="k-card k-card--hover">

                        <?php
                        $image_id = absint( $card['image'] ?? 0 );

                        if ( $image_id ) :
                            ?>

                            <div class="k-card__image">
                                <?php
                                echo wp_get_attachment_image(
                                    $image_id,
                                    'large',
                                    false,
                                    array(
                                        'loading' => 'lazy',
                                        'alt'     => (string) ( $card['title'] ?? '' ),
                                    )
                                );
                                ?>
                            </div>

                        <?php endif; ?>

                        <div class="k-card__content">

                            <h3 class="k-card__title">
                                <?php echo esc_html( (string) ( $card['title'] ?? '' ) ); ?>
                            </h3>

                            <?php if ( ! empty( $card['desc'] ) ) : ?>

                                <p class="k-card__text">
                                    <?php echo esc_html( (string) $card['desc'] ); ?>
                                </p>

                            <?php endif; ?>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>
        -->

    </div>

</section>

<!-- Slide 2 -->
<section class="k-section k-section--light" id="intro" data-animate>
	<div class="k-section__inner">
		<header class="k-section__head">
			<h2 class="display-md second-slide second-slide--gold"><?php echo esc_html( (string) kenda_ppt( 'slide_02', 'heading' ) ); ?></h2>
			<!-- <p class="slide-02-blue-text"><?php echo esc_html( (string) kenda_ppt( 'slide_02', 'eyebrow' ) ); ?></p> -->
			<p class="k-section__lead"><?php echo esc_html( (string) kenda_ppt( 'slide_02', 'intro' ) ); ?></p>
		</header>
		<div class="k-split">
			<div class="k-card k-card--soft">
				<!-- <h3 class="k-card__title slide-02-dark-blue"><?php esc_html_e( 'Thank you for the opportunity', 'kenda-custom' ); ?></h3> -->
				<ul class="k-list">
					<?php foreach ( $s02_bullets as $line ) : ?>
						<li><?php echo esc_html( $line ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="k-card k-card--soft">
				<h3 class="k-card__title slide-02-dark-blue"><?php echo esc_html( (string) kenda_ppt( 'slide_02', 'scope_title' ) ); ?></h3>
				<ul class="k-list">
					<?php foreach ( $s02_scope as $line ) : ?>
						<li><?php echo esc_html( $line ); ?></li>	
					<?php endforeach; ?>
				</ul>
			</div>
			<!-- <details class="k-disclosure k-disclosure--gold">
				<summary class="k-disclosure__summary"><?php echo esc_html( (string) kenda_ppt( 'slide_02', 'scope_title' ) ); ?></summary>
				<div class="k-disclosure__body">
					<ul class="k-list k-list--compact">
						<?php foreach ( $s02_scope as $line ) : ?>
							<li><?php echo esc_html( $line ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</details> -->
		</div>
	</div>
</section>


<!-- Slide 7 --> 
 <!-- platform details -->
<section class="k-section" id="priorities" data-animate>

    <div class="k-section__inner">

        <header class="k-section__head">

            <h2 class="display-md">
                <?php
                echo esc_html(
                    kenda_home(
                        'priorities_heading',
                        __( 'Sentiment Analysis: What Greater Kansas City Thinks', 'kenda-custom' )
                    )
                );
                ?>
            </h2>

            <!-- <p class="k-section__lead">
                <?php echo esc_html( kenda_home( 'priorities_intro', '' ) ); ?>
            </p> -->

            <!-- <?php if ( kenda_ppt( 'slide_07', 'deliverable' ) ) : ?>

                <p class="k-note">
                    <?php echo esc_html( (string) kenda_ppt( 'slide_07', 'deliverable' ) ); ?>
                </p>

            <?php endif; ?> -->

        </header>


        <!-- FIRST ACCORDION -->
        <!-- <div class="k-accordion" data-priority-accordion>

            <?php if ( is_array( $s07_table ) ) : ?>

                <?php foreach ( $s07_table as $i => $row ) : ?>

                    <?php
                    if ( ! is_array( $row ) ) {
                        continue;
                    }

                    $panel_id = 'k-pillar-panel-' . (int) $i;
                    ?>

                    <article class="k-accordion__item">

                        <button
                            type="button"
                            class="k-accordion__trigger"
                            data-slide07-toggle
                            aria-expanded="false"
                            aria-controls="<?php echo esc_attr( $panel_id ); ?>"
                        >

                            <span class="k-accordion__label">
                                <?php echo esc_html( (string) ( $row['pillar'] ?? '' ) ); ?>
                            </span>

                            <span
                                class="k-accordion__icon"
                                aria-hidden="true"
                            ></span>

                        </button>


                        <div
                            class="k-accordion__panel"
                            id="<?php echo esc_attr( $panel_id ); ?>"
                            hidden
                        >

                            <p>
                                <strong>
                                    <?php esc_html_e( 'What we measure', 'kenda-custom' ); ?>
                                </strong>
                                —
                                <?php echo esc_html( (string) ( $row['measure'] ?? '' ) ); ?>
                            </p>

                            <p>
                                <strong>
                                    <?php esc_html_e( 'How it shapes the message', 'kenda-custom' ); ?>
                                </strong>
                                —
                                <?php echo esc_html( (string) ( $row['message'] ?? '' ) ); ?>
                            </p>

                        </div>

                    </article>

                <?php endforeach; ?>

            <?php endif; ?>

        </div> -->


        <!-- PLATFORM DETAILS -->
		<?php if ( $priority_full_query->have_posts() ) : ?>

			<h3 class="k-subhead">
				<?php esc_html_e( 'Platform details', 'kenda-custom' ); ?>
			</h3>

			<div class="k-platform-details">

				<?php
				$j = 0;

				while ( $priority_full_query->have_posts() ) :
					$priority_full_query->the_post();

					$num   = get_post_meta( get_the_ID(), 'priority_number', true );
					$short = get_post_meta( get_the_ID(), 'priority_short_description', true );
					?>

					<article class="k-platform-detail">

						<div class="k-platform-detail__header">

							<span class="k-platform-detail__num">
								<?php
								echo esc_html(
									$num
										? (string) $num
										: sprintf( '%02d', $j + 1 )
								);
								?>
							</span>

							<div class="k-platform-detail__info">

								<h4 class="k-platform-detail__title">
									<?php the_title(); ?>
								</h4>

								<?php if ( $short ) : ?>
									<p class="k-platform-detail__short">
										<?php echo esc_html( (string) $short ); ?>
									</p>
								<?php endif; ?>

							</div>

						</div>

						<?php if ( get_the_content() ) : ?>
							<div class="k-platform-detail__content k-prose">
								<?php the_content(); ?>
							</div>
						<?php endif; ?>

						<?php
						$popup = (string) get_post_meta( get_the_ID(), 'priority_popup_content', true );
						if ( '' !== trim( wp_strip_all_tags( $popup ) ) ) :
							$platform_modal_id = 'k-platform-modal-' . (int) get_the_ID();
							?>
							<button
								type="button"
								class="k-platform-detail__more"
								data-platform-open="<?php echo esc_attr( $platform_modal_id ); ?>"
								aria-haspopup="dialog"
								aria-controls="<?php echo esc_attr( $platform_modal_id ); ?>"
							>
								<?php esc_html_e( 'Learn More', 'kenda-custom' ); ?>
								<span aria-hidden="true">→</span>
							</button>

							<dialog
								class="k-platform-modal"
								id="<?php echo esc_attr( $platform_modal_id ); ?>"
								aria-labelledby="<?php echo esc_attr( $platform_modal_id ); ?>-title"
							>
								<div class="k-platform-modal__panel">
									<button type="button" class="k-platform-modal__close" data-platform-close aria-label="<?php esc_attr_e( 'Close', 'kenda-custom' ); ?>">
										<span aria-hidden="true">&times;</span>
									</button>
									<h3 class="k-platform-modal__title" id="<?php echo esc_attr( $platform_modal_id ); ?>-title">
										<?php the_title(); ?>
									</h3>
									<div class="k-platform-modal__body k-prose">
										<?php echo apply_filters( 'the_content', $popup ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized with wp_kses_post on save. ?>
									</div>
								</div>
							</dialog>
						<?php endif; ?>

					</article>

					<?php ++$j; ?>

				<?php endwhile; ?>

				<?php wp_reset_postdata(); ?>

			</div>

		<?php endif; ?>

    </div>

</section>

<!-- Slide 8 -->
<section class="k-section k-section--muted" id="get-involved" data-animate>
	<div class="k-section__inner">
		<header class="k-section__head">
			<div class="k-slide08-head__row">

				<h2 class="display-md">
					<?php echo esc_html( (string) kenda_ppt( 'slide_08', 'heading' ) ); ?>
				</h2>

				<h2 class="display-md k-slide08-stat">
					<?php echo esc_html( (string) kenda_ppt( 'slide_08', 'stat' ) ); ?>
				</h2>

			</div>
			<p class="k-section__lead"><?php echo esc_html( (string) kenda_ppt( 'slide_08', 'lead' ) ); ?></p>
			<p class="k-stat-line"><strong><?php echo esc_html( (string) kenda_ppt( 'slide_08', 'strategy' ) ); ?></strong> <?php echo esc_html( (string) kenda_ppt( 'slide_08', 'stat' ) ); ?></p>
			
		</header>
		<div class="k-platform-details k-slide08-details">
			<article class="k-platform-detail">
				<div class="k-platform-detail__header">
					<span class="k-platform-detail__num">
						01
					</span>

					<div class="k-platform-detail__info">

						<h4 class="k-platform-detail__title">
							<?php esc_html_e( 'Responsible spending:', 'kenda-custom' ); ?>
						</h4>

						<?php if ( ! empty( $s08_includes ) ) : ?>
							<p class="k-platform-detail__short">
								<?php echo esc_html( implode( ' ', $s08_includes ) ); ?>
							</p>
						<?php endif; ?>

					</div>
				</div>

			</article>

			<article class="k-platform-detail">

				<div class="k-platform-detail__header">

					<span class="k-platform-detail__num">
						02
					</span>

					<div class="k-platform-detail__info">

						<h4 class="k-platform-detail__title">
							<?php echo esc_html(
								(string) kenda_ppt(
									'slide_08',
									'opt_title'
								)
							); ?>
						</h4>

						<?php if ( ! empty( $opt_content ) ) : ?>
							<p class="k-platform-detail__short">
								<?php echo esc_html( implode( ' ', $opt_content ) ); ?>
							</p>
						<?php endif; ?>

					</div>

				</div>

			</article>

			<article class="k-platform-detail">

				<div class="k-platform-detail__header">

					<span class="k-platform-detail__num">
						03
					</span>

					<div class="k-platform-detail__info">

						<h4 class="k-platform-detail__title">
							<?php echo esc_html(
								(string) kenda_ppt(
									'slide_08',
									'human'
								)
							); ?>
						</h4>

						<?php if ( ! empty( $s08_opt ) ) : ?>
							<p class="k-platform-detail__short">
								<?php echo esc_html( implode( ' ', $s08_opt ) ); ?>
							</p>
						<?php endif; ?>

					</div>

				</div>
			</article>

		</div>
		<!-- <div class="k-chips">
			<?php foreach ( kenda_ppt( 'slide_08', 'taglines', array() ) as $tag ) : ?>
				<h1><?php echo esc_html( (string) $tag ); ?></h2>
			<?php endforeach; ?>
		</div> -->
		<!-- <?php if ( kenda_home( 'involved_cta_text' ) && kenda_home( 'involved_cta_url' ) ) : ?>
			<p class="k-section__cta">
				<a class="btn btn--gold btn--lg js-scroll-link" href="<?php echo esc_url( kenda_home( 'involved_cta_url', '#contact' ) ); ?>"><?php echo esc_html( kenda_home( 'involved_cta_text' ) ); ?></a>
			</p>
		<?php endif; ?> -->
	</div>
</section>

<!-- page 3 -->
<section class="k-section k-section--light" id="about" data-animate>

    <div class="k-section__inner">

        <header class="k-section__head">

            <?php if ( kenda_home( 'about_eyebrow' ) ) : ?>

                <p class="eyebrow k-about-eyebrow">
					<?php echo esc_html( kenda_home( 'about_eyebrow' ) ); ?>
				</p>

            <?php endif; ?>

            <h2 class="display-md">
                <?php
                echo esc_html(
                    kenda_home(
                        'about_heading',
                        __( "The Candidate's Story", 'kenda-custom' )
                    )
                );
                ?>
            </h2>

            <p class="k-section__lead">
                <?php
                echo esc_html(
                    kenda_home(
                        'experience_intro',
                        __( '30+ years in finance and civic leadership', 'kenda-custom' )
                    )
                );
                ?>
            </p>

        </header>

        <?php if ( kenda_home( 'about_body' ) ) : ?>

            <div class="k-prose k-about-story">

                <?php
                echo kenda_content(
                    (string) kenda_home( 'about_body' )
                ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                ?>

            </div>

        <?php endif; ?>


        <?php if ( $pillar_preview_query->have_posts() ) : ?>

            <div class="k-about-pillars">

                <!-- <div class="k-about-pillars__head">

                    <p class="eyebrow">
                        <?php esc_html_e( 'Leadership Priorities', 'kenda-custom' ); ?>
                    </p>

                    <h3>
                        <?php esc_html_e( 'Experience that translates into action', 'kenda-custom' ); ?>
                    </h3>

                </div> -->
				<section class="k-campaign-closing" id="campaign-closing">

					<!-- IN KENDA'S WORDS -->
					<div class="k-campaign-closing__block k-campaign-closing__quote">

						<?php if ( kenda_home( 'words_heading' ) ) : ?>
							<p class="eyebrow">
								<?php echo esc_html( kenda_home( 'words_heading' ) ); ?>
							</p>
						<?php endif; ?>

						<?php if ( kenda_home( 'words_quote' ) ) : ?>
							<blockquote class="k-campaign-closing__quote-text">
								“<?php echo esc_html( kenda_home( 'words_quote' ) ); ?>”
							</blockquote>
						<?php endif; ?>

						<?php if ( kenda_home( 'words_author' ) ) : ?>
							<p class="k-campaign-closing__author">
								<?php echo esc_html( kenda_home( 'words_author' ) ); ?>
							</p>
						<?php endif; ?>

					</div>


					<!-- YOUR VOICE. YOUR VOTE. -->
					<div class="k-campaign-closing__block k-campaign-closing__voice">

						<?php if ( kenda_home( 'voice_heading' ) ) : ?>
							<h2 class="display-md">
								<?php echo esc_html( kenda_home( 'voice_heading' ) ); ?>
							</h2>
						<?php endif; ?>

						<?php if ( kenda_home( 'voice_subheading' ) ) : ?>
							<h3 class="k-campaign-closing__subheading">
								<?php echo esc_html( kenda_home( 'voice_subheading' ) ); ?>
							</h3>
						<?php endif; ?>

						<?php if ( kenda_home( 'voice_body' ) ) : ?>
							<p class="k-campaign-closing__body">
								<?php echo esc_html( kenda_home( 'voice_body' ) ); ?>
							</p>
						<?php endif; ?>

					</div>


					<!-- HELP BRING ACCOUNTABILITY BACK -->
					<div class="k-campaign-closing__block k-campaign-closing__support">

						<?php if ( kenda_home( 'support_heading' ) ) : ?>
							<h2 class="display-md">
								<?php echo esc_html( kenda_home( 'support_heading' ) ); ?>
							</h2>
						<?php endif; ?>

						<?php if ( kenda_home( 'support_label' ) ) : ?>
							<div class="k-campaign-closing__cta">
								<?php echo esc_html( kenda_home( 'support_label' ) ); ?>
							</div>
						<?php endif; ?>

						<?php if ( kenda_home( 'support_description' ) ) : ?>
							<p class="k-campaign-closing__body">
								<?php echo esc_html( kenda_home( 'support_description' ) ); ?>
							</p>
						<?php endif; ?>

					</div>

				</section>
				
				<section class="k-actions" id="campaign-actions">

					<!-- ==============================
						DONATION
						============================== -->

					<div class="k-actions-donation">

						<div class="k-actions-donation__amounts">

							<?php
							$donation_amounts = preg_split(
								'/\r\n|\r|\n/',
								(string) kenda_home( 'donation_amounts', '' )
							);

							$donation_amounts = array_values(
								array_filter(
									array_map( 'trim', $donation_amounts )
								)
							);
							?>

							<?php foreach ( $donation_amounts as $amount ) : ?>

								<?php
								$display_amount = is_numeric( $amount )
									? '$' . $amount
									: $amount;
								?>

								<button
									type="button"
									class="k-actions-donation__amount"
									data-donation-amount="<?php echo esc_attr( $amount ); ?>"
								>
									<?php echo esc_html( $display_amount ); ?>
								</button>

							<?php endforeach; ?>

						</div>


						<?php
						$donate_text = kenda_home(
							'donate_button_text',
							'DONATE'
						);

						$donate_url = kenda_home(
							'donate_button_url',
							''
						);
						?>

						<?php if ( $donate_text ) : ?>

							<?php if ( $donate_url ) : ?>

								<a
									href="<?php echo esc_url( $donate_url ); ?>"
									class="k-actions-btn k-actions-btn--gold"
								>
									<?php echo esc_html( $donate_text ); ?>
								</a>

							<?php else : ?>

								<button
									type="button"
									class="k-actions-btn k-actions-btn--gold"
								>
									<?php echo esc_html( $donate_text ); ?>
								</button>

							<?php endif; ?>

						<?php endif; ?>

					</div>


					<!-- ==============================
						JOIN THE TEAM
						============================== -->

					<div class="k-actions-card k-actions-team">

						<div class="k-actions-card__inner">

							<?php if ( kenda_home( 'team_heading' ) ) : ?>

								<h2 class="k-actions-card__title">

									<?php echo esc_html(
										kenda_home( 'team_heading' )
									); ?>

								</h2>

							<?php endif; ?>


							<?php if ( kenda_home( 'team_description' ) ) : ?>

								<p class="k-actions-card__text">

									<?php echo esc_html(
										kenda_home( 'team_description' )
									); ?>

								</p>

							<?php endif; ?>


							<?php
							$team_text = kenda_home(
								'team_button_text',
								'GET INVOLVED'
							);

							$team_url = kenda_home(
								'team_button_url',
								''
							);
							?>

							<?php if ( $team_text ) : ?>

								<?php if ( $team_url ) : ?>

									<a
										href="<?php echo esc_url( $team_url ); ?>"
										class="k-actions-btn k-actions-btn--navy"
									>
										<?php echo esc_html( $team_text ); ?>
									</a>

								<?php else : ?>

									<button
										type="button"
										class="k-actions-btn k-actions-btn--navy"
									>
										<?php echo esc_html( $team_text ); ?>
									</button>

								<?php endif; ?>

							<?php endif; ?>

						</div>

					</div>


					<!-- ==============================
						TEXT UPDATES
						============================== -->

					<div class="k-actions-card k-actions-updates">

						<div class="k-actions-card__inner">

							<?php if ( kenda_home( 'text_updates_heading' ) ) : ?>

								<h2 class="k-actions-card__title">

									<?php echo esc_html(
										kenda_home( 'text_updates_heading' )
									); ?>

								</h2>

							<?php endif; ?>


							<?php
							$form_action = kenda_home(
								'text_updates_form_action',
								''
							);
							?>

							<form
								class="k-actions-form"
								method="post"
								action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"
							>
								<input type="hidden" name="action" value="kenda_text_signup">

								<?php wp_nonce_field( 'kenda_text_signup', 'kenda_text_signup_nonce' ); ?>

								<div class="k-actions-form__fields">

									<div class="k-actions-form__field">

										<label for="k-actions-name">
											<?php echo esc_html(
												kenda_home(
													'text_updates_name_label',
													'Name'
												)
											); ?>
										</label>

										<input
											id="k-actions-name"
											type="text"
											name="name"
											autocomplete="name"
											required
										>

									</div>

									<div class="k-actions-form__field">

										<label for="k-actions-mobile">
											<?php echo esc_html(
												kenda_home(
													'text_updates_mobile_label',
													'Mobile'
												)
											); ?>
										</label>

										<input
											id="k-actions-mobile"
											type="tel"
											name="mobile"
											autocomplete="tel"
											required
										>

									</div>

									<div class="k-actions-form__field">

										<label for="k-actions-zip">
											<?php echo esc_html(
												kenda_home(
													'text_updates_zip_label',
													'Zip Code'
												)
											); ?>
										</label>

										<input
											id="k-actions-zip"
											type="text"
											name="zip_code"
											inputmode="numeric"
											autocomplete="postal-code"
											required
										>

									</div>

								</div>

								<label class="k-actions-consent">

									<input
										type="checkbox"
										name="sms_consent"
										value="1"
										required
									>

									<span>
										<?php echo esc_html(
											kenda_home(
												'text_updates_disclaimer',
												''
											)
										); ?>
									</span>

								</label>

								<?php
								$updates_button_text = kenda_home(
									'text_updates_button_text',
									'SIGN ME UP'
								);
								?>

								<?php if ( $updates_button_text ) : ?>

									<button
										type="submit"
										class="k-actions-btn k-actions-btn--navy"
									>
										<?php echo esc_html( $updates_button_text ); ?>
									</button>

								<?php endif; ?>

							</form>

						</div>

					</div>

				</section>
            </div>

        <?php endif; ?>

    </div>

</section>

<!-- Slide 4 -->
<!-- <section class="k-section k-section--muted" data-animate>

    <div class="k-section__inner">

        <header class="k-section__head">

            <h2 class="display-md">
                <?php echo esc_html( (string) kenda_ppt( 'slide_04', 'heading' ) ); ?>

                <span class="k-inline-accent">
                    <?php echo esc_html( (string) kenda_ppt( 'slide_04', 'arrow_title' ) ); ?>
                </span>
            </h2>

            <p class="k-section__lead">
                <?php echo esc_html( (string) kenda_ppt( 'slide_04', 'lead' ) ); ?>
            </p>

        </header>

        <?php if ( is_array( $s04_steps ) && $s04_steps ) : ?>

            <div class="k-card-grid k-card-grid--2" data-k-accordion>

                <?php foreach ( $s04_steps as $i => $step ) : ?>

                    <?php
                    if ( ! is_array( $step ) ) {
                        continue;
                    }

					$panel_id = 'k-slide-04-panel-' . (int) $i;
                    $lines    = kenda_ppt_lines( (string) ( $step['desc'] ?? '' ) );
                    ?>

                    <article class="k-card k-card--step">

                        <button
                            type="button"
                            class="k-accordion__trigger"
							data-slide04-toggle
                            aria-expanded="false"
                            aria-controls="<?php echo esc_attr( $panel_id ); ?>"
                        >
                            <span class="k-step-num">
                                <?php echo esc_html( (string) ( $step['num'] ?? '' ) ); ?>
                            </span>

                            <span class="k-accordion__label">
                                <?php echo esc_html( (string) ( $step['title'] ?? '' ) ); ?>
                            </span>

                            <span
                                class="k-accordion__icon"
                                aria-hidden="true"
                            ></span>
                        </button>

                        <div
                            class="k-accordion__panel"
                            id="<?php echo esc_attr( $panel_id ); ?>"
                            hidden
                        >
                            <?php foreach ( $lines as $line ) : ?>

                                <p class="k-card__text">
                                    <?php echo esc_html( $line ); ?>
                                </p>

                            <?php endforeach; ?>
                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</section> -->

<!-- Slide 6 -->
<!-- <section class="k-section k-section--light" id="about" data-animate>
	<div class="k-section__inner">
		<header class="k-section__head">
		<?php if ( kenda_home( 'about_eyebrow' ) ) : ?>
				<p class="eyebrow"><?php echo esc_html( kenda_home( 'about_eyebrow' ) ); ?></p>
			<?php endif; ?>
			<h2 class="display-md"><?php echo esc_html( kenda_home( 'about_heading', __( "The Candidate's Story", 'kenda-custom' ) ) ); ?></h2>
			<p class="k-section__lead"><?php echo esc_html( kenda_home( 'experience_intro', __( '30+ years in finance and civic leadership', 'kenda-custom' ) ) ); ?></p>
		</header>
		<div class="k-split">
			<div class="k-prose">
				<?php if ( kenda_home( 'about_body' ) ) : ?>
					<?php echo kenda_content( (string) kenda_home( 'about_body' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php endif; ?>
			</div>
			<?php if ( $pillar_preview_query->have_posts() ) : ?>
				<div class="k-card-grid k-card-grid--1">
					<?php
					while ( $pillar_preview_query->have_posts() ) :
						$pillar_preview_query->the_post();
						$short = get_post_meta( get_the_ID(), 'priority_short_description', true );
						?>
						<article class="k-card k-card--pillar">
							<h3 class="k-card__title"><?php the_title(); ?></h3>
							<p class="k-card__text"><?php echo esc_html( $short ? (string) $short : wp_strip_all_tags( get_the_content() ) ); ?></p>
						</article>
					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section> -->

<!-- Slide 5 -->
<!-- <section class="k-section k-section--dark" id="vision" data-animate>
	<div class="k-section__inner">
		<header class="k-section__head k-section__head--light">
			<h2 class="display-md"><?php echo esc_html( (string) kenda_ppt( 'slide_05', 'heading' ) ); ?></h2>
			<p class="k-section__lead"><?php echo esc_html( (string) kenda_ppt( 'slide_05', 'subheading' ) ); ?></p>
		</header>
		<div class="k-card-grid k-card-grid--2">
			<div class="k-card k-card--glass">
				<ul class="k-list k-list--light">
					<?php foreach ( $s05_bullets as $line ) : ?>
						<li><?php echo esc_html( $line ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="k-stack">
				<div class="k-callout k-callout--gold">
					<p class="k-callout__label"><?php echo esc_html( (string) kenda_ppt( 'slide_05', 'formula_label' ) ); ?></p>
					<p class="k-callout__value"><?php echo esc_html( (string) kenda_ppt( 'slide_05', 'formula_text' ) ); ?></p>
				</div>
				<div class="k-callout k-callout--outline">
					<p class="k-callout__label"><?php echo esc_html( (string) kenda_ppt( 'slide_05', 'objective_label' ) ); ?></p>
					<p class="k-callout__text"><?php echo esc_html( (string) kenda_ppt( 'slide_05', 'objective_text' ) ); ?></p>
				</div>
			</div>
		</div>
	</div>
</section> -->


<!-- Slide 9 -->
<!-- <section class="k-section" data-animate>
	<div class="k-section__inner">
		<header class="k-section__head">
			<h2 class="display-md"><?php echo esc_html( (string) kenda_ppt( 'slide_09', 'heading' ) ); ?></h2>
			<p class="k-section__lead"><?php echo esc_html( (string) kenda_ppt( 'slide_09', 'subheading' ) ); ?></p>
			<p class="eyebrow k-about-eyebrow"><?php echo esc_html( (string) kenda_ppt( 'slide_09', 'logos_label' ) ); ?></p>
			<div class="k-chips">
				<?php foreach ( $s09_logos as $logo ) : ?>
					<span class="k-chip k-chip--outline"><?php echo esc_html( (string) $logo ); ?></span>
				<?php endforeach; ?>
			</div>
		</header>
		<div class="k-card-grid k-card-grid--3">
			<article class="k-card k-card--hover">
				<h3 class="k-card__title"><?php echo esc_html( (string) kenda_ppt( 'slide_09', 'target_title' ) ); ?></h3>
				<ul class="k-list k-list--compact">
					<?php foreach ( kenda_ppt_lines( (string) kenda_ppt( 'slide_09', 'target', '' ) ) as $line ) : ?>
						<li><?php echo esc_html( $line ); ?></li>
					<?php endforeach; ?>
				</ul>
			</article>
			<article class="k-card k-card--hover">
				<h3 class="k-card__title"><?php echo esc_html( (string) kenda_ppt( 'slide_09', 'attrib_title' ) ); ?></h3>
				<ul class="k-list k-list--compact">
					<?php foreach ( kenda_ppt_lines( (string) kenda_ppt( 'slide_09', 'attrib', '' ) ) as $line ) : ?>
						<li><?php echo esc_html( $line ); ?></li>
					<?php endforeach; ?>
				</ul>
			</article>
			<article class="k-card k-card--hover">
				<h3 class="k-card__title"><?php echo esc_html( (string) kenda_ppt( 'slide_09', 'video_title' ) ); ?></h3>
				<ul class="k-list k-list--compact">
					<?php foreach ( kenda_ppt_lines( (string) kenda_ppt( 'slide_09', 'video', '' ) ) as $line ) : ?>
						<li><?php echo esc_html( $line ); ?></li>
					<?php endforeach; ?>
				</ul>
			</article>
		</div>
	</div>
</section> -->

<!-- Slide 10 -->
<!-- <section class="k-section k-section--light" data-animate>
	<div class="k-section__inner">
		<header class="k-section__head">
			<h2 class="display-md"><?php echo esc_html( (string) kenda_ppt( 'slide_10', 'heading' ) ); ?></h2>
			<p class="k-section__lead"><?php echo esc_html( (string) kenda_ppt( 'slide_10', 'subheading' ) ); ?></p>
		</header>
		<?php if ( is_array( $s10_services ) && $s10_services ) : ?>
			<div class="k-card-grid k-card-grid--3">
				<?php foreach ( $s10_services as $service ) : ?>
					<?php if ( ! is_array( $service ) ) { continue; } ?>
					<article class="k-card k-card--service">
						<span class="k-service-num"><?php echo esc_html( (string) ( $service['num'] ?? '' ) ); ?></span>
						<h3 class="k-card__title"><?php echo esc_html( (string) ( $service['title'] ?? '' ) ); ?></h3>
						<p class="k-card__text"><?php echo esc_html( (string) ( $service['desc'] ?? '' ) ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section> -->

<!-- Slide 11 -->
<!-- <section class="k-section k-section--dark" id="experience" data-animate>
	<div class="k-section__inner">
		<header class="k-section__head k-section__head--light">
			<h2 class="display-md"><?php echo esc_html( (string) kenda_ppt( 'slide_11', 'heading', __( 'Service Delivery Timeline', 'kenda-custom' ) ) ); ?></h2>
			<p class="k-section__lead"><?php echo esc_html( (string) kenda_ppt( 'slide_11', 'subheading', '' ) ); ?></p>
		</header>
		<?php if ( is_array( $timeline ) && $timeline ) : ?>
			<div class="k-timeline-scroll">
				<?php foreach ( $timeline as $phase ) : ?>
					<?php if ( ! is_array( $phase ) ) { continue; } ?>
					<article class="k-card k-card--timeline">
						<span class="k-step-num"><?php echo esc_html( (string) ( $phase['num'] ?? '' ) ); ?></span>
						<p class="k-timeline-period"><?php echo esc_html( (string) ( $phase['period'] ?? '' ) ); ?></p>
						<h3 class="k-card__title"><?php echo esc_html( (string) ( $phase['title'] ?? '' ) ); ?></h3>
						<p class="k-card__text"><?php echo esc_html( (string) ( $phase['desc'] ?? '' ) ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<!-- <?php if ( $experience_query->have_posts() ) : ?>
			<h3 class="k-subhead k-subhead--light"><?php echo esc_html( kenda_home( 'experience_heading', __( 'Leadership & Experience', 'kenda-custom' ) ) ); ?></h3>
			<ol class="timeline timeline--home">
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
		<?php endif; ?> -->
	</div>
</section> 

<!-- Slide 12 -->
<!-- <section class="k-section k-section--gold" id="support" data-animate>
	<div class="k-section__inner">
		<header class="k-section__head">
			 <h2 class="display-md">
                <?php
                echo esc_html(
                    (string) kenda_ppt(
                        'slide_12',
                        'heading',
                        ''
                    )
                );
                ?>
            </h2>
			<p class="k-section__lead"><?php echo esc_html( (string) kenda_ppt( 'slide_12', 'subheading' ) ); ?></p>
		</header>
		<div class="k-slide12-total">

			<div class="k-slide12-total__amount">
				<?php
				echo esc_html(
					(string) kenda_ppt(
						'slide_12',
						'total',
						''
					)
				);
				?>
			</div>

			<div class="k-slide12-total__label">
				<?php
				echo esc_html(
					(string) kenda_ppt(
						'slide_12',
						'total_label',
						''
					)
				);
				?>
			</div>

		</div>
		<div class="k-card-grid k-card-grid--2">
			<?php foreach ( $s12_payments as $payment ) : ?>
				<?php if ( ! is_array( $payment ) ) { continue; } ?>
				<article class="k-card k-card--payment">
					<h3 class="k-card__title"><?php echo esc_html( (string) ( $payment['label'] ?? '' ) ); ?></h3>
					<p class="k-payment-amount"><?php echo esc_html( (string) ( $payment['amount'] ?? '' ) ); ?></p>
					<p class="k-card__text"><?php echo esc_html( (string) ( $payment['note'] ?? '' ) ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	
		<p class="k-fineprint"><?php echo esc_html( (string) kenda_ppt( 'slide_12', 'disclaimer' ) ); ?></p>
		<p class="k-quote"><?php echo esc_html( (string) kenda_ppt( 'slide_12', 'quote' ) ); ?></p>
		<!-- <?php if ( kenda_home( 'cta_button_text' ) && kenda_home( 'cta_button_url', kenda_site( 'donation_url' ) ) ) : ?>
			<p class="k-section__cta">
				<a class="btn btn--donate btn--lg" href="<?php echo esc_url( kenda_home( 'cta_button_url', kenda_site( 'donation_url' ) ) ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( kenda_home( 'cta_button_text' ) ); ?></a>
			</p>
		<?php endif; ?> -->
	</div>
</section> 

<!-- Slide 13 -->
<!-- <section class="k-section k-section--muted" data-animate>
	<div class="k-section__inner">
		<header class="k-section__head">
			<h2 class="display-md"><?php echo esc_html( (string) kenda_ppt( 'slide_13', 'heading' ) ); ?></h2>
		</header>
		<div class="k-wins-grid">
			<?php foreach ( $s13_bullets as $line ) : ?>
				<article class="k-card k-card--win">
					<p class="k-card__text"><?php echo esc_html( $line ); ?></p>
				</article>
				<?php endforeach; ?>
			</div>
			<p class="k-section__lead"><?php echo esc_html( (string) kenda_ppt( 'slide_13', 'subheading' ) ); ?></p>
			<p class="k-note"><?php echo esc_html( (string) kenda_ppt( 'slide_13', 'intro' ) ); ?></p>
	</div>
</section> -->

<style>
#intro .k-section__head {
    max-width: 100%;
}

#intro .second-slide {
    width: 100%;
    max-width: none;
}
</style>