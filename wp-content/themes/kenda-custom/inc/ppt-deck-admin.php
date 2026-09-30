<?php
/**
 * Admin UI for PPT deck section content (slides 2–14).
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'admin_menu',
	function (): void {
		add_submenu_page(
			'kenda-site',
			__( 'PPT Deck Sections', 'kenda-custom' ),
			__( 'PPT Deck Sections', 'kenda-custom' ),
			'edit_pages',
			'kenda-ppt-deck',
			'kenda_render_ppt_deck_settings_page'
		);
	}
);

/**
 * Load assets for the PPT Deck Sections admin page.
 */
function kenda_ppt_deck_admin_assets( string $hook ): void {

    if ( 'kenda-ppt-deck' !== ( $_GET['page'] ?? '' ) ) {
        return;
    }

    wp_enqueue_media();

    wp_enqueue_script(
        'kenda-ppt-admin',
        get_template_directory_uri() . '/assets/js/kenda-ppt-admin.js',
        array( 'jquery' ),
        '1.0.0',
        true
    );
}

add_action( 'admin_enqueue_scripts', 'kenda_ppt_deck_admin_assets' );

/**
 * @param array<string, mixed> $slide_data Current slide values.
 */
function kenda_ppt_admin_row( string $slide, string $key, string $label, array $slide_data, string $type = 'text' ): void {
	$val = $slide_data[ $key ] ?? '';
	$id  = $slide . '_' . $key;
	$name = 'kenda_ppt_settings[' . $slide . '][' . $key . ']';
	?>
	<tr>
		<th scope="row"><label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></label></th>
		<td>
			<?php if ( 'textarea' === $type ) : ?>
				<textarea name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $id ); ?>" rows="5" class="large-text"><?php echo esc_textarea( is_string( $val ) ? $val : '' ); ?></textarea>
				<?php if ( str_contains( $key, 'bullets' ) || str_contains( $key, 'includes' ) ) : ?>
					<p class="description"><?php esc_html_e( 'One bullet per line. You may start lines with •', 'kenda-custom' ); ?></p>
				<?php endif; ?>
			<?php else : ?>
				<input type="text" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $id ); ?>" value="<?php echo esc_attr( is_string( $val ) ? $val : '' ); ?>" class="large-text" />
			<?php endif; ?>
		</td>
	</tr>
	<?php
}

/**
 * @param array<string, mixed> $input Raw POST data.
 * @return array<string, array<string, mixed>>
 */
function kenda_sanitize_ppt_settings( array $input ): array {
	$defaults = kenda_ppt_default_slides();
	$out      = $defaults;

	foreach ( $input as $slide_key => $slide_val ) {
		if ( ! is_string( $slide_key ) || ! is_array( $slide_val ) ) {
			continue;
		}
		$slide_key = sanitize_key( $slide_key );
		if ( ! isset( $defaults[ $slide_key ] ) ) {
			continue;
		}

		foreach ( $slide_val as $field_key => $field_val ) {
			$field_key = sanitize_key( (string) $field_key );

			if ( 'image' === $field_key ) {
				$out[ $slide_key ][ $field_key ] = absint( $field_val );
				continue;
			}

			if ( 'cards' === $field_key && is_array( $field_val ) ) {
				$cards = array();
				foreach ( $field_val as $card ) {
					if ( ! is_array( $card ) ) {
						continue;
					}
					$image = absint( $card['image'] ?? 0 );
					$title = sanitize_text_field( (string) ( $card['title'] ?? '' ) );
					$desc  = sanitize_text_field( (string) ( $card['desc'] ?? '' ) );
					 if ( 0 === $image && '' === $title && '' === $desc ) {
						continue;
					}
					$cards[] = array(
						'image' => $image,
						'title' => $title,
						'desc'  => $desc,
					);
				}
				$out[ $slide_key ]['cards'] = $cards;
				continue;
			}

			if ( 'steps' === $field_key && is_array( $field_val ) ) {
				$steps = array();
				foreach ( $field_val as $step ) {
					if ( ! is_array( $step ) ) {
						continue;
					}
					$steps[] = array(
						'num'   => sanitize_text_field( (string) ( $step['num'] ?? '' ) ),
						'title' => sanitize_text_field( (string) ( $step['title'] ?? '' ) ),
						'desc'  => sanitize_textarea_field( (string) ( $step['desc'] ?? '' ) ),
					);
				}
				$out[ $slide_key ]['steps'] = $steps;
				continue;
			}

			if ( 'services' === $field_key && is_array( $field_val ) ) {
				$services = array();
				foreach ( $field_val as $service ) {
					if ( ! is_array( $service ) ) {
						continue;
					}
					$services[] = array(
						'num'   => sanitize_text_field( (string) ( $service['num'] ?? '' ) ),
						'title' => sanitize_text_field( (string) ( $service['title'] ?? '' ) ),
						'desc'  => sanitize_text_field( (string) ( $service['desc'] ?? '' ) ),
					);
				}
				$out[ $slide_key ]['services'] = $services;
				continue;
			}

			if ( 'payments' === $field_key && is_array( $field_val ) ) {
				$payments = array();
				foreach ( $field_val as $payment ) {
					if ( ! is_array( $payment ) ) {
						continue;
					}
					$payments[] = array(
						'label'  => sanitize_text_field( (string) ( $payment['label'] ?? '' ) ),
						'amount' => sanitize_text_field( (string) ( $payment['amount'] ?? '' ) ),
						'note'   => sanitize_text_field( (string) ( $payment['note'] ?? '' ) ),
					);
				}
				$out[ $slide_key ]['payments'] = $payments;
				continue;
			}

			if ( 'phases' === $field_key && is_array( $field_val ) ) {
				$phases = array();
				foreach ( $field_val as $phase ) {
					if ( ! is_array( $phase ) ) {
						continue;
					}
					$phases[] = array(
						'num'    => sanitize_text_field( (string) ( $phase['num'] ?? '' ) ),
						'period' => sanitize_text_field( (string) ( $phase['period'] ?? '' ) ),
						'title'  => sanitize_text_field( (string) ( $phase['title'] ?? '' ) ),
						'desc'   => sanitize_textarea_field( (string) ( $phase['desc'] ?? '' ) ),
					);
				}
				$out[ $slide_key ]['phases'] = $phases;
				continue;
			}

			if ( 'table' === $field_key && is_array( $field_val ) ) {
				$rows = array();
				foreach ( $field_val as $row ) {
					if ( ! is_array( $row ) ) {
						continue;
					}
					$rows[] = array(
						'pillar'  => sanitize_text_field( (string) ( $row['pillar'] ?? '' ) ),
						'measure' => sanitize_textarea_field( (string) ( $row['measure'] ?? '' ) ),
						'message' => sanitize_textarea_field( (string) ( $row['message'] ?? '' ) ),
					);
				}
				$out[ $slide_key ]['table'] = $rows;
				continue;
			}

			if ( 'taglines' === $field_key && is_array( $field_val ) ) {
				$out[ $slide_key ]['taglines'] = array_values(
					array_filter(
						array_map(
							static fn( $v ) => sanitize_text_field( (string) $v ),
							$field_val
						)
					)
				);
				continue;
			}

			if ( 'logos' === $field_key ) {
				if ( is_string( $field_val ) ) {
					$logos = kenda_ppt_lines( sanitize_textarea_field( $field_val ) );
				} elseif ( is_array( $field_val ) ) {
					$logos = array_values(
						array_filter(
							array_map(
								static fn( $v ) => sanitize_text_field( (string) $v ),
								$field_val
							)
						)
					);
				} else {
					$logos = array();
				}
				$out[ $slide_key ]['logos'] = $logos;
				continue;
			}

			if ( is_string( $field_val ) ) {
				if ( in_array( $field_key, array( 'bullets', 'includes', 'optimized', 'target', 'attrib', 'video' ), true ) ) {
					$out[ $slide_key ][ $field_key ] = sanitize_textarea_field( $field_val );
				} else {
					$out[ $slide_key ][ $field_key ] = sanitize_text_field( $field_val );
				}
			}
		}
	}

	return $out;
}

function kenda_render_ppt_deck_settings_page(): void {
	if ( ! current_user_can( 'edit_pages' ) ) {
		return;
	}

	if ( isset( $_POST['kenda_ppt_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['kenda_ppt_nonce'] ) ), 'kenda_save_ppt' ) ) {
		$raw   = wp_unslash( $_POST['kenda_ppt_settings'] ?? array() );
		$clean = kenda_sanitize_ppt_settings( is_array( $raw ) ? $raw : array() );
		update_option( 'kenda_ppt_settings', $clean );
		echo '<div class="notice notice-success"><p>' . esc_html__( 'PPT deck sections saved.', 'kenda-custom' ) . '</p></div>';
	}

	$data = kenda_ppt_slides();
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'PPT Deck Sections', 'kenda-custom' ); ?></h1>
		<p class="description">
			<?php esc_html_e( 'Edit homepage deck content for slides 2–14. Slide 1 (hero), About (slide 6 headings/body), Support button, and Contact remain under Homepage Content. Experience & Priorities cards are edited under their post types.', 'kenda-custom' ); ?>
		</p>
		<form method="post">
			<?php wp_nonce_field( 'kenda_save_ppt', 'kenda_ppt_nonce' ); ?>

			<h2><?php esc_html_e( 'Slide 2 — Scope & Campaign Window', 'kenda-custom' ); ?></h2>
			<table class="form-table"><?php
				kenda_ppt_admin_row( 'slide_02', 'eyebrow', __( 'Eyebrow', 'kenda-custom' ), $data['slide_02'] );
				kenda_ppt_admin_row( 'slide_02', 'heading', __( 'Heading', 'kenda-custom' ), $data['slide_02'] );
				kenda_ppt_admin_row( 'slide_02', 'intro', __( 'Intro', 'kenda-custom' ), $data['slide_02'] );
				kenda_ppt_admin_row( 'slide_02', 'bullets', __( 'Bullets', 'kenda-custom' ), $data['slide_02'], 'textarea' );
				kenda_ppt_admin_row( 'slide_02', 'scope_title', __( 'Scope box title', 'kenda-custom' ), $data['slide_02'] );
				kenda_ppt_admin_row( 'slide_02', 'scope_bullets', __( 'Scope box bullets', 'kenda-custom' ), $data['slide_02'], 'textarea' );
			?></table>

			<h2><?php esc_html_e( 'Slide 3 — Team / Capabilities Grid', 'kenda-custom' ); ?></h2>
			<table class="form-table"><?php
				kenda_ppt_admin_row( 'slide_03', 'heading', __( 'Heading', 'kenda-custom' ), $data['slide_03'] );
				kenda_ppt_admin_row( 'slide_03', 'subheading', __( 'Subheading', 'kenda-custom' ), $data['slide_03'] );
				kenda_ppt_admin_row( 'slide_03', 'stat', __( 'Highlight stat', 'kenda-custom' ), $data['slide_03'] );
				kenda_ppt_admin_row( 'slide_03', 'tags', __( 'Tag line', 'kenda-custom' ), $data['slide_03'] );
			?></table>
			<h3><?php esc_html_e( 'Cards', 'kenda-custom' ); ?></h3>
			<table class="widefat striped">

				<thead>
					<tr>
						<th style="width: 25%;">
							<?php esc_html_e( 'Image', 'kenda-custom' ); ?>
						</th>

						<th style="width: 30%;">
							<?php esc_html_e( 'Title', 'kenda-custom' ); ?>
						</th>

						<th style="width: 45%;">
							<?php esc_html_e( 'Description', 'kenda-custom' ); ?>
						</th>
					</tr>
				</thead>

				<tbody>

				<?php
				$cards = $data['slide_03']['cards'] ?? array();

				for ( $i = 0; $i < 8; $i++ ) :

					$card = $cards[ $i ] ?? array(
						'image' => '',
						'title' => '',
						'desc'  => '',
					);

					$image_id = absint( $card['image'] ?? 0 );
					?>

					<tr>

						<!-- Image -->
						<td>

							<div class="kenda-card-image-field">

								<div
									class="kenda-card-image-preview"
									id="kenda-card-image-preview-<?php echo (int) $i; ?>"
									style="margin-bottom:10px;"
								>

									<?php if ( $image_id ) : ?>

										<?php
										echo wp_get_attachment_image(
											$image_id,
											'medium',
											false,
											array(
												'style' => 'max-width:150px;height:auto;display:block;',
											)
										);
										?>

									<?php endif; ?>

								</div>

								<input
									type="hidden"
									class="kenda-card-image-id"
									id="kenda-card-image-<?php echo (int) $i; ?>"
									name="kenda_ppt_settings[slide_03][cards][<?php echo (int) $i; ?>][image]"
									value="<?php echo esc_attr( $image_id ); ?>"
								/>

								<button
									type="button"
									class="button kenda-select-card-image"
									data-card-index="<?php echo (int) $i; ?>"
								>
									<?php esc_html_e( 'Choose Image', 'kenda-custom' ); ?>
								</button>

								<button
									type="button"
									class="button kenda-remove-card-image"
									data-card-index="<?php echo (int) $i; ?>"
									<?php echo $image_id ? '' : 'style="display:none;"'; ?>
								>
									<?php esc_html_e( 'Remove', 'kenda-custom' ); ?>
								</button>

							</div>

						</td>

						<!-- Title -->
						<td>

							<input
								type="text"
								class="large-text"
								name="kenda_ppt_settings[slide_03][cards][<?php echo (int) $i; ?>][title]"
								value="<?php echo esc_attr( (string) ( $card['title'] ?? '' ) ); ?>"
							/>

						</td>

						<!-- Description -->
						<td>

							<input
								type="text"
								class="large-text"
								name="kenda_ppt_settings[slide_03][cards][<?php echo (int) $i; ?>][desc]"
								value="<?php echo esc_attr( (string) ( $card['desc'] ?? '' ) ); ?>"
							/>

						</td>

					</tr>

				<?php endfor; ?>

				</tbody>

			</table>

			<h2><?php esc_html_e( 'Slide 4 — Website Revamp Steps', 'kenda-custom' ); ?></h2>
			<table class="form-table"><?php
				kenda_ppt_admin_row( 'slide_04', 'heading', __( 'Heading', 'kenda-custom' ), $data['slide_04'] );
				kenda_ppt_admin_row( 'slide_04', 'arrow_title', __( 'Arrow title', 'kenda-custom' ), $data['slide_04'] );
				kenda_ppt_admin_row( 'slide_04', 'lead', __( 'Lead', 'kenda-custom' ), $data['slide_04'], 'textarea' );
			?></table>
			<?php
			$steps = $data['slide_04']['steps'] ?? array();
			for ( $i = 0; $i < 4; $i++ ) :
				$step = $steps[ $i ] ?? array( 'num' => (string) ( $i + 1 ), 'title' => '', 'desc' => '' );
				?>
				<h3><?php printf( esc_html__( 'Step %d', 'kenda-custom' ), $i + 1 ); ?></h3>
				<table class="form-table">
					<tr>
						<th><?php esc_html_e( 'Number', 'kenda-custom' ); ?></th>
						<td><input type="text" name="kenda_ppt_settings[slide_04][steps][<?php echo (int) $i; ?>][num]" value="<?php echo esc_attr( (string) ( $step['num'] ?? '' ) ); ?>" class="small-text" /></td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Title', 'kenda-custom' ); ?></th>
						<td><input type="text" name="kenda_ppt_settings[slide_04][steps][<?php echo (int) $i; ?>][title]" value="<?php echo esc_attr( (string) ( $step['title'] ?? '' ) ); ?>" class="large-text" /></td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Body (one paragraph per line)', 'kenda-custom' ); ?></th>
						<td><textarea name="kenda_ppt_settings[slide_04][steps][<?php echo (int) $i; ?>][desc]" rows="4" class="large-text"><?php echo esc_textarea( (string) ( $step['desc'] ?? '' ) ); ?></textarea></td>
					</tr>
				</table>
			<?php endfor; ?>

			<h2><?php esc_html_e( 'Slide 5 — How You Win', 'kenda-custom' ); ?></h2>
			<table class="form-table"><?php
				kenda_ppt_admin_row( 'slide_05', 'heading', __( 'Heading', 'kenda-custom' ), $data['slide_05'] );
				kenda_ppt_admin_row( 'slide_05', 'subheading', __( 'Subheading', 'kenda-custom' ), $data['slide_05'] );
				kenda_ppt_admin_row( 'slide_05', 'bullets', __( 'Bullets', 'kenda-custom' ), $data['slide_05'], 'textarea' );
				kenda_ppt_admin_row( 'slide_05', 'formula_label', __( 'Formula label', 'kenda-custom' ), $data['slide_05'] );
				kenda_ppt_admin_row( 'slide_05', 'formula_text', __( 'Formula text', 'kenda-custom' ), $data['slide_05'] );
				kenda_ppt_admin_row( 'slide_05', 'objective_label', __( 'Objective label', 'kenda-custom' ), $data['slide_05'] );
				kenda_ppt_admin_row( 'slide_05', 'objective_text', __( 'Objective text', 'kenda-custom' ), $data['slide_05'], 'textarea' );
			?></table>

			<h2><?php esc_html_e( 'Slide 7 — Priorities Table', 'kenda-custom' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Section title & intro: Homepage Content → Priorities. Table rows:', 'kenda-custom' ); ?></p>
			<table class="form-table"><?php
				kenda_ppt_admin_row( 'slide_07', 'deliverable', __( 'Deliverable line', 'kenda-custom' ), $data['slide_07'], 'textarea' );
			?></table>
			<?php
			$table = $data['slide_07']['table'] ?? array();
			for ( $i = 0; $i < 3; $i++ ) :
				$row = $table[ $i ] ?? array( 'pillar' => '', 'measure' => '', 'message' => '' );
				?>
				<h3><?php printf( esc_html__( 'Table row %d', 'kenda-custom' ), $i + 1 ); ?></h3>
				<table class="form-table">
					<tr><th><?php esc_html_e( 'Pillar', 'kenda-custom' ); ?></th><td><input type="text" class="large-text" name="kenda_ppt_settings[slide_07][table][<?php echo (int) $i; ?>][pillar]" value="<?php echo esc_attr( (string) ( $row['pillar'] ?? '' ) ); ?>" /></td></tr>
					<tr><th><?php esc_html_e( 'What we measure', 'kenda-custom' ); ?></th><td><textarea name="kenda_ppt_settings[slide_07][table][<?php echo (int) $i; ?>][measure]" rows="2" class="large-text"><?php echo esc_textarea( (string) ( $row['measure'] ?? '' ) ); ?></textarea></td></tr>
					<tr><th><?php esc_html_e( 'Message', 'kenda-custom' ); ?></th><td><textarea name="kenda_ppt_settings[slide_07][table][<?php echo (int) $i; ?>][message]" rows="2" class="large-text"><?php echo esc_textarea( (string) ( $row['message'] ?? '' ) ); ?></textarea></td></tr>
				</table>
			<?php endfor; ?>

			<h2><?php esc_html_e( 'Slide 8 — TargetText / Get Involved', 'kenda-custom' ); ?></h2>
			<table class="form-table"><?php
				kenda_ppt_admin_row( 'slide_08', 'heading', __( 'Heading', 'kenda-custom' ), $data['slide_08'] );
				kenda_ppt_admin_row( 'slide_08', 'strategy', __( 'Strategy label', 'kenda-custom' ), $data['slide_08'] );
				kenda_ppt_admin_row( 'slide_08', 'stat', __( 'Stat line', 'kenda-custom' ), $data['slide_08'] );
				kenda_ppt_admin_row( 'slide_08', 'lead', __( 'Lead', 'kenda-custom' ), $data['slide_08'], 'textarea' );
				kenda_ppt_admin_row( 'slide_08', 'includes', __( 'What is included', 'kenda-custom' ), $data['slide_08'], 'textarea' );
				  // NEW FIELD
				kenda_ppt_admin_row(
					'slide_08',
					'opt_content',
					__( 'Opt content', 'kenda-custom' ),
					$data['slide_08'],
					'textarea'
				);
				kenda_ppt_admin_row( 'slide_08', 'opt_title', __( 'Optimization title', 'kenda-custom' ), $data['slide_08'] );
				kenda_ppt_admin_row( 'slide_08', 'human', __( 'Human oversight label', 'kenda-custom' ), $data['slide_08'] );
				kenda_ppt_admin_row( 'slide_08', 'optimized', __( 'Optimization bullets', 'kenda-custom' ), $data['slide_08'], 'textarea' );
			?></table>
			<h3><?php esc_html_e( 'Taglines', 'kenda-custom' ); ?></h3>
			<table class="form-table">
				<?php for ( $i = 0; $i < 3; $i++ ) : ?>
					<tr>
						<th><?php printf( esc_html__( 'Tagline %d', 'kenda-custom' ), $i + 1 ); ?></th>
						<td><input type="text" class="large-text" name="kenda_ppt_settings[slide_08][taglines][<?php echo (int) $i; ?>]" value="<?php echo esc_attr( (string) ( ( $data['slide_08']['taglines'][ $i ] ?? '' ) ) ); ?>" /></td>
					</tr>
				<?php endfor; ?>
			</table>

			<h2><?php esc_html_e( 'Slide 9 — Streaming TV', 'kenda-custom' ); ?></h2>
			<table class="form-table"><?php
				kenda_ppt_admin_row( 'slide_09', 'heading', __( 'Heading', 'kenda-custom' ), $data['slide_09'] );
				kenda_ppt_admin_row( 'slide_09', 'subheading', __( 'Subheading', 'kenda-custom' ), $data['slide_09'] );
				kenda_ppt_admin_row( 'slide_09', 'logos_label', __( 'Logos label', 'kenda-custom' ), $data['slide_09'] );
				$logos_raw = implode( "\n", (array) ( $data['slide_09']['logos'] ?? array() ) );
				?>
				<tr>
					<th><label for="slide_09_logos"><?php esc_html_e( 'Logo chips (one per line)', 'kenda-custom' ); ?></label></th>
					<td><textarea name="kenda_ppt_settings[slide_09][logos]" id="slide_09_logos" rows="4" class="large-text"><?php echo esc_textarea( $logos_raw ); ?></textarea></td>
				</tr>
				<?php
				kenda_ppt_admin_row( 'slide_09', 'target_title', __( 'Targeting title', 'kenda-custom' ), $data['slide_09'] );
				kenda_ppt_admin_row( 'slide_09', 'target', __( 'Targeting bullets', 'kenda-custom' ), $data['slide_09'], 'textarea' );
				kenda_ppt_admin_row( 'slide_09', 'attrib_title', __( 'Attribution title', 'kenda-custom' ), $data['slide_09'] );
				kenda_ppt_admin_row( 'slide_09', 'attrib', __( 'Attribution bullets', 'kenda-custom' ), $data['slide_09'], 'textarea' );
				kenda_ppt_admin_row( 'slide_09', 'video_title', __( 'Video title', 'kenda-custom' ), $data['slide_09'] );
				kenda_ppt_admin_row( 'slide_09', 'video', __( 'Video bullets', 'kenda-custom' ), $data['slide_09'], 'textarea' );
			?></table>

			<h2><?php esc_html_e( 'Slide 10 — Services Grid', 'kenda-custom' ); ?></h2>
			<table class="form-table"><?php
				kenda_ppt_admin_row( 'slide_10', 'heading', __( 'Heading', 'kenda-custom' ), $data['slide_10'] );
				kenda_ppt_admin_row( 'slide_10', 'subheading', __( 'Subheading', 'kenda-custom' ), $data['slide_10'] );
			?></table>
			<?php
			$services = $data['slide_10']['services'] ?? array();
			for ( $i = 0; $i < 6; $i++ ) :
				$s = $services[ $i ] ?? array( 'num' => (string) ( $i + 1 ), 'title' => '', 'desc' => '' );
				?>
				<h3><?php printf( esc_html__( 'Service %d', 'kenda-custom' ), $i + 1 ); ?></h3>
				<table class="form-table">
					<tr><th><?php esc_html_e( 'Number', 'kenda-custom' ); ?></th><td><input type="text" class="small-text" name="kenda_ppt_settings[slide_10][services][<?php echo (int) $i; ?>][num]" value="<?php echo esc_attr( (string) ( $s['num'] ?? '' ) ); ?>" /></td></tr>
					<tr><th><?php esc_html_e( 'Title', 'kenda-custom' ); ?></th><td><input type="text" class="large-text" name="kenda_ppt_settings[slide_10][services][<?php echo (int) $i; ?>][title]" value="<?php echo esc_attr( (string) ( $s['title'] ?? '' ) ); ?>" /></td></tr>
					<tr><th><?php esc_html_e( 'Description', 'kenda-custom' ); ?></th><td><textarea name="kenda_ppt_settings[slide_10][services][<?php echo (int) $i; ?>][desc]" rows="2" class="large-text"><?php echo esc_textarea( (string) ( $s['desc'] ?? '' ) ); ?></textarea></td></tr>
				</table>
			<?php endfor; ?>

			<h2><?php esc_html_e( 'Slide 11 — Timeline', 'kenda-custom' ); ?></h2>
			<table class="form-table"><?php
				kenda_ppt_admin_row( 'slide_11', 'heading', __( 'Heading', 'kenda-custom' ), $data['slide_11'] );
				kenda_ppt_admin_row( 'slide_11', 'subheading', __( 'Subheading', 'kenda-custom' ), $data['slide_11'] );
			?></table>
			<?php
			$phases = $data['slide_11']['phases'] ?? array();
			for ( $i = 0; $i < 5; $i++ ) :
				$p = $phases[ $i ] ?? array( 'num' => (string) ( $i + 1 ), 'period' => '', 'title' => '', 'desc' => '' );
				?>
				<h3><?php printf( esc_html__( 'Phase %d', 'kenda-custom' ), $i + 1 ); ?></h3>
				<table class="form-table">
					<tr><th><?php esc_html_e( 'Number', 'kenda-custom' ); ?></th><td><input type="text" class="small-text" name="kenda_ppt_settings[slide_11][phases][<?php echo (int) $i; ?>][num]" value="<?php echo esc_attr( (string) ( $p['num'] ?? '' ) ); ?>" /></td></tr>
					<tr><th><?php esc_html_e( 'Period', 'kenda-custom' ); ?></th><td><input type="text" class="large-text" name="kenda_ppt_settings[slide_11][phases][<?php echo (int) $i; ?>][period]" value="<?php echo esc_attr( (string) ( $p['period'] ?? '' ) ); ?>" /></td></tr>
					<tr><th><?php esc_html_e( 'Title', 'kenda-custom' ); ?></th><td><input type="text" class="large-text" name="kenda_ppt_settings[slide_11][phases][<?php echo (int) $i; ?>][title]" value="<?php echo esc_attr( (string) ( $p['title'] ?? '' ) ); ?>" /></td></tr>
					<tr><th><?php esc_html_e( 'Description', 'kenda-custom' ); ?></th><td><textarea name="kenda_ppt_settings[slide_11][phases][<?php echo (int) $i; ?>][desc]" rows="3" class="large-text"><?php echo esc_textarea( (string) ( $p['desc'] ?? '' ) ); ?></textarea></td></tr>
				</table>
			<?php endfor; ?>

			<h2><?php esc_html_e( 'Slide 12 — Support / Investment', 'kenda-custom' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Donate button: Homepage Content → Support / CTA.', 'kenda-custom' ); ?></p>
			<table class="form-table"><?php
				kenda_ppt_admin_row( 'slide_12', 'heading', __( 'Heading (fallback if CTA heading empty)', 'kenda-custom' ), $data['slide_12'] );
				kenda_ppt_admin_row( 'slide_12', 'subheading', __( 'Subheading', 'kenda-custom' ), $data['slide_12'] );
				kenda_ppt_admin_row( 'slide_12', 'total', __( 'Total amount', 'kenda-custom' ), $data['slide_12'] );
				kenda_ppt_admin_row( 'slide_12', 'total_label', __( 'Total label', 'kenda-custom' ), $data['slide_12'] );
				kenda_ppt_admin_row( 'slide_12', 'quote', __( 'Quote', 'kenda-custom' ), $data['slide_12'], 'textarea' );
				kenda_ppt_admin_row( 'slide_12', 'disclaimer', __( 'Fine print', 'kenda-custom' ), $data['slide_12'], 'textarea' );
			?></table>
			<?php
			$payments = $data['slide_12']['payments'] ?? array();
			for ( $i = 0; $i < 2; $i++ ) :
				$pay = $payments[ $i ] ?? array( 'label' => '', 'amount' => '', 'note' => '' );
				?>
				<h3><?php printf( esc_html__( 'Payment block %d', 'kenda-custom' ), $i + 1 ); ?></h3>
				<table class="form-table">
					<tr><th><?php esc_html_e( 'Label', 'kenda-custom' ); ?></th><td><input type="text" class="large-text" name="kenda_ppt_settings[slide_12][payments][<?php echo (int) $i; ?>][label]" value="<?php echo esc_attr( (string) ( $pay['label'] ?? '' ) ); ?>" /></td></tr>
					<tr><th><?php esc_html_e( 'Amount', 'kenda-custom' ); ?></th><td><input type="text" class="large-text" name="kenda_ppt_settings[slide_12][payments][<?php echo (int) $i; ?>][amount]" value="<?php echo esc_attr( (string) ( $pay['amount'] ?? '' ) ); ?>" /></td></tr>
					<tr><th><?php esc_html_e( 'Note', 'kenda-custom' ); ?></th><td><input type="text" class="large-text" name="kenda_ppt_settings[slide_12][payments][<?php echo (int) $i; ?>][note]" value="<?php echo esc_attr( (string) ( $pay['note'] ?? '' ) ); ?>" /></td></tr>
				</table>
			<?php endfor; ?>

			<h2><?php esc_html_e( 'Slide 13 — Why This Wins', 'kenda-custom' ); ?></h2>
			<table class="form-table"><?php
				kenda_ppt_admin_row( 'slide_13', 'heading', __( 'Heading', 'kenda-custom' ), $data['slide_13'] );
				kenda_ppt_admin_row( 'slide_13', 'subheading', __( 'Subheading', 'kenda-custom' ), $data['slide_13'] );
				kenda_ppt_admin_row( 'slide_13', 'intro', __( 'Intro', 'kenda-custom' ), $data['slide_13'], 'textarea' );
				kenda_ppt_admin_row( 'slide_13', 'bullets', __( 'Bullets', 'kenda-custom' ), $data['slide_13'], 'textarea' );
			?></table>

			<!-- <h2><?php esc_html_e( 'Slide 14 — Thank You (before contact)', 'kenda-custom' ); ?></h2>
			<table class="form-table"><?php
				kenda_ppt_admin_row( 'slide_14', 'heading', __( 'Heading', 'kenda-custom' ), $data['slide_14'] );
				kenda_ppt_admin_row( 'slide_14', 'subheading', __( 'Subheading', 'kenda-custom' ), $data['slide_14'] );
				kenda_ppt_admin_row( 'slide_14', 'line_1', __( 'Optional line 1', 'kenda-custom' ), $data['slide_14'] );
				kenda_ppt_admin_row( 'slide_14', 'line_2', __( 'Optional line 2', 'kenda-custom' ), $data['slide_14'] );
				kenda_ppt_admin_row( 'slide_14', 'line_3', __( 'Optional line 3', 'kenda-custom' ), $data['slide_14'] );
				kenda_ppt_admin_row( 'slide_14', 'line_4', __( 'Optional line 4 (URL text)', 'kenda-custom' ), $data['slide_14'] );
				kenda_ppt_admin_row( 'slide_14', 'line_5', __( 'Optional line 5', 'kenda-custom' ), $data['slide_14'] );
				kenda_ppt_admin_row( 'slide_14', 'thank_you', __( 'Thank you headline', 'kenda-custom' ), $data['slide_14'] );
			?></table> -->

			<h2>
				<?php esc_html_e( 'Slide 14 — Thank You (before contact)', 'kenda-custom' ); ?>
			</h2>

			<table class="form-table">

				<?php
				kenda_ppt_admin_row(
					'slide_14',
					'heading',
					__( 'Heading', 'kenda-custom' ),
					$data['slide_14']
				);

				$slide14_image_id = absint(
					$data['slide_14']['image'] ?? 0
				);
				?>

				<tr>
					<th scope="row">
						<label for="kenda-slide14-image">
							<?php esc_html_e( 'Thank You Image', 'kenda-custom' ); ?>
						</label>
					</th>

					<td>

						<input
							type="hidden"
							id="kenda-slide14-image"
							name="kenda_ppt_settings[slide_14][image]"
							value="<?php echo esc_attr( $slide14_image_id ); ?>"
						>

						<div
							id="kenda-slide14-image-preview"
							style="margin-bottom: 10px;"
						>

							<?php if ( $slide14_image_id ) : ?>

								<?php
								echo wp_get_attachment_image(
									$slide14_image_id,
									'medium',
									false,
									array(
										'style' => 'max-width:300px;height:auto;display:block;',
									)
								);
								?>

							<?php endif; ?>

						</div>

						<button
							type="button"
							class="button kenda-slide14-select-image"
						>
							<?php esc_html_e( 'Choose Image', 'kenda-custom' ); ?>
						</button>

						<button
							type="button"
							class="button kenda-slide14-remove-image"
							<?php echo $slide14_image_id ? '' : 'style="display:none;"'; ?>
						>
							<?php esc_html_e( 'Remove Image', 'kenda-custom' ); ?>
						</button>

						<p class="description">
							<?php
							esc_html_e(
								'Select an image for the left side of the Thank You section.',
								'kenda-custom'
							);
							?>
						</p>

					</td>
				</tr>

				<?php

				kenda_ppt_admin_row(
					'slide_14',
					'subheading',
					__( 'Subheading', 'kenda-custom' ),
					$data['slide_14']
				);

				kenda_ppt_admin_row(
					'slide_14',
					'line_1',
					__( 'Optional line 1', 'kenda-custom' ),
					$data['slide_14']
				);

				kenda_ppt_admin_row(
					'slide_14',
					'line_2',
					__( 'Optional line 2', 'kenda-custom' ),
					$data['slide_14']
				);

				kenda_ppt_admin_row(
					'slide_14',
					'line_3',
					__( 'Optional line 3', 'kenda-custom' ),
					$data['slide_14']
				);

				kenda_ppt_admin_row(
					'slide_14',
					'line_4',
					__( 'Optional line 4 (URL text)', 'kenda-custom' ),
					$data['slide_14']
				);

				kenda_ppt_admin_row(
					'slide_14',
					'line_5',
					__( 'Optional line 5', 'kenda-custom' ),
					$data['slide_14']
				);

				kenda_ppt_admin_row(
					'slide_14',
					'thank_you',
					__( 'Thank you headline', 'kenda-custom' ),
					$data['slide_14']
				);

				?>

			</table>

			<?php submit_button( __( 'Save PPT Deck Sections', 'kenda-custom' ) ); ?>
		</form>
	</div>
	<?php
}
