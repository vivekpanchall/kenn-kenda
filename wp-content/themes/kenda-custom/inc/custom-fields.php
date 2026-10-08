<?php
/**
 * Admin settings for homepage and site options.
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
		add_menu_page(
			__( 'Campaign Site', 'kenda-custom' ),
			__( 'Campaign Site', 'kenda-custom' ),
			'edit_pages',
			'kenda-site',
			'kenda_render_homepage_settings_page',
			'dashicons-admin-home',
			3
		);

		add_submenu_page(
			'kenda-site',
			__( 'Homepage Content', 'kenda-custom' ),
			__( 'Homepage Content', 'kenda-custom' ),
			'edit_pages',
			'kenda-site',
			'kenda_render_homepage_settings_page'
		);

		add_submenu_page(
			'kenda-site',
			__( 'Site Settings', 'kenda-custom' ),
			__( 'Site Settings', 'kenda-custom' ),
			'manage_options',
			'kenda-site-settings',
			'kenda_render_site_settings_page'
		);
	}
);

/**
 * Render media picker field.
 */
function kenda_admin_media_field( string $name, string $label, $value, string $help = '' ): void {
	$id   = absint( $value );
	$url  = $id ? wp_get_attachment_url( $id ) : '';
	$preview = $url ? '<img src="' . esc_url( $url ) . '" style="max-width:120px;height:auto;" />' : '';
	?>
	<tr>
		<th scope="row"><label><?php echo esc_html( $label ); ?></label></th>
		<td>
			<div class="kenda-media-field" data-field="<?php echo esc_attr( $name ); ?>">
				<input type="hidden" name="kenda_homepage_settings[<?php echo esc_attr( $name ); ?>]" value="<?php echo esc_attr( (string) $id ); ?>" class="kenda-media-id" />
				<div class="kenda-media-preview"><?php echo $preview; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
				<button type="button" class="button kenda-media-select"><?php esc_html_e( 'Select Media', 'kenda-custom' ); ?></button>
				<button type="button" class="button kenda-media-remove"><?php esc_html_e( 'Remove', 'kenda-custom' ); ?></button>
				<?php if ( $help ) : ?>
					<p class="description"><?php echo esc_html( $help ); ?></p>
				<?php endif; ?>
			</div>
		</td>
	</tr>
	<?php
}

/**
 * Text field row for homepage settings.
 */
function kenda_admin_text_row( string $key, string $label, array $options, string $type = 'text', string $help = '' ): void {
	$val = $options[ $key ] ?? '';
	?>
	<tr>
		<th scope="row"><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
		<td>
			<?php if ( 'textarea' === $type ) : ?>
				<textarea name="kenda_homepage_settings[<?php echo esc_attr( $key ); ?>]" id="<?php echo esc_attr( $key ); ?>" rows="4" class="large-text"><?php echo esc_textarea( (string) $val ); ?></textarea>
			<?php else : ?>
				<input type="<?php echo esc_attr( $type ); ?>" name="kenda_homepage_settings[<?php echo esc_attr( $key ); ?>]" id="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( (string) $val ); ?>" class="regular-text" />
			<?php endif; ?>
			<?php if ( $help ) : ?>
				<p class="description"><?php echo esc_html( $help ); ?></p>
			<?php endif; ?>
		</td>
	</tr>
	<?php
}

function kenda_render_homepage_settings_page(): void {
	if ( ! current_user_can( 'edit_pages' ) ) {
		return;
	}

	if ( isset( $_POST['kenda_homepage_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['kenda_homepage_nonce'] ) ), 'kenda_save_homepage' ) ) {
		$raw     = wp_unslash( $_POST['kenda_homepage_settings'] ?? array() );
		$clean   = kenda_sanitize_homepage_settings( is_array( $raw ) ? $raw : array() );
		update_option( 'kenda_homepage_settings', $clean );
		echo '<div class="notice notice-success"><p>' . esc_html__( 'Homepage content saved.', 'kenda-custom' ) . '</p></div>';
	}

	$options = get_option( 'kenda_homepage_settings', array() );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Homepage Content', 'kenda-custom' ); ?></h1>
		<p class="description">
			<?php esc_html_e( 'Hero (slide 1), About (slide 6), Support button, and Contact labels are edited here.', 'kenda-custom' ); ?>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=kenda-ppt-deck' ) ); ?>"><?php esc_html_e( 'Edit slides 2–14 content (shown on homepage)', 'kenda-custom' ); ?></a>
		</p>
		<form method="post">
			<?php wp_nonce_field( 'kenda_save_homepage', 'kenda_homepage_nonce' ); ?>
			<h2 class="title"><?php esc_html_e( 'Hero — Slide 1', 'kenda-custom' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Matches PPT slide 1 typography. Name splits into up to three lines (e.g. KENDA / TOMES / McCLAIN).', 'kenda-custom' ); ?></p>
			<table class="form-table" role="presentation">
				<?php
				kenda_admin_text_row( 'hero_elect', __( 'ELECT line', 'kenda-custom' ), $options );
				kenda_admin_text_row( 'hero_title', __( 'Candidate name (full)', 'kenda-custom' ), $options );
				kenda_admin_text_row( 'hero_subtitle', __( 'Subtitle (blue line)', 'kenda-custom' ), $options, 'textarea' );
				kenda_admin_text_row( 'hero_eyebrow', __( 'Office line (gold)', 'kenda-custom' ), $options );
				kenda_admin_text_row( 'hero_credit_line', __( 'Credit line (blue)', 'kenda-custom' ), $options );
				kenda_admin_text_row( 'hero_services_line', __( 'Services line (gold)', 'kenda-custom' ), $options, 'textarea' );
				kenda_admin_text_row( 'hero_website_line', __( 'Website text / URL', 'kenda-custom' ), $options );
				kenda_admin_text_row( 'hero_description', __( 'Optional extra paragraph (below deck lines)', 'kenda-custom' ), $options, 'textarea' );
				kenda_admin_media_field( 'hero_video', __( 'Hero Video', 'kenda-custom' ), $options['hero_video'] ?? 0, __( 'MP4 from Media Library. Autoplay muted on desktop; poster used on mobile.', 'kenda-custom' ) );
				kenda_admin_media_field( 'hero_poster', __( 'Hero Poster Image', 'kenda-custom' ), $options['hero_poster'] ?? 0 );
				kenda_admin_text_row( 'hero_primary_text', __( 'Primary Button Text', 'kenda-custom' ), $options );
				kenda_admin_text_row( 'hero_primary_url', __( 'Primary Button URL', 'kenda-custom' ), $options, 'url' );
				kenda_admin_text_row( 'hero_secondary_text', __( 'Secondary Button Text', 'kenda-custom' ), $options );
				kenda_admin_text_row( 'hero_secondary_url', __( 'Secondary Button URL', 'kenda-custom' ), $options, 'url' );
				?>
			</table>

			<h2 class="title"><?php esc_html_e( 'Introduction', 'kenda-custom' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php
				kenda_admin_text_row( 'intro_eyebrow', __( 'Section Label', 'kenda-custom' ), $options );
				kenda_admin_text_row( 'intro_heading', __( 'Introduction Heading', 'kenda-custom' ), $options );
				kenda_admin_text_row( 'intro_lead', __( 'Lead Statement', 'kenda-custom' ), $options, 'textarea' );
				kenda_admin_text_row( 'intro_body', __( 'Supporting Paragraph', 'kenda-custom' ), $options, 'textarea' );
				?>
			</table>

			<h2 class="title"><?php esc_html_e( 'About', 'kenda-custom' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php
				kenda_admin_text_row( 'about_eyebrow', __( 'Section Label', 'kenda-custom' ), $options );
				kenda_admin_text_row( 'about_heading', __( 'About Heading', 'kenda-custom' ), $options );
				kenda_admin_text_row( 'about_body', __( 'Biography Content', 'kenda-custom' ), $options, 'textarea' );
				kenda_admin_media_field( 'about_image', __( 'About Image / Header Portrait', 'kenda-custom' ), $options['about_image'] ?? 0, __( 'Used in the site header and hero portrait. Campaign shield stays on slide 1 only (Customizer → Logo).', 'kenda-custom' ) );
				kenda_admin_text_row( 'about_facts', __( 'Supporting Facts (one per line)', 'kenda-custom' ), $options, 'textarea' );
				?>
			</table>

			<h2 class="title"><?php esc_html_e( 'Experience Section', 'kenda-custom' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Edit individual entries under Campaign Site → Experience.', 'kenda-custom' ); ?></p>
			<table class="form-table" role="presentation">
				<?php
				kenda_admin_text_row( 'experience_eyebrow', __( 'Section Label', 'kenda-custom' ), $options );
				kenda_admin_text_row( 'experience_heading', __( 'Section Heading', 'kenda-custom' ), $options );
				kenda_admin_text_row( 'experience_intro', __( 'Section Introduction', 'kenda-custom' ), $options, 'textarea' );
				?>
			</table>

			<h2 class="title"><?php esc_html_e( 'Priorities Section', 'kenda-custom' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Edit cards under Campaign Site → Priorities.', 'kenda-custom' ); ?></p>
			<table class="form-table" role="presentation">
				<?php
				kenda_admin_text_row( 'priorities_eyebrow', __( 'Section Label', 'kenda-custom' ), $options );
				kenda_admin_text_row( 'priorities_heading', __( 'Section Heading', 'kenda-custom' ), $options );
				kenda_admin_text_row( 'priorities_intro', __( 'Section Introduction', 'kenda-custom' ), $options, 'textarea' );
				?>
			</table>

			<h2 class="title"><?php esc_html_e( 'Vision', 'kenda-custom' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php
				kenda_admin_text_row( 'vision_eyebrow', __( 'Section Label', 'kenda-custom' ), $options );
				kenda_admin_text_row( 'vision_heading', __( 'Vision Heading', 'kenda-custom' ), $options );
				kenda_admin_text_row( 'vision_body', __( 'Vision Content', 'kenda-custom' ), $options, 'textarea' );
				kenda_admin_media_field( 'vision_image', __( 'Vision Image', 'kenda-custom' ), $options['vision_image'] ?? 0 );
				?>
			</table>

			<h2 class="title"><?php esc_html_e( 'Campaign Closing Content', 'kenda-custom' ); ?></h2>

			<p class="description">
				<?php esc_html_e( 'Edit the campaign closing sections displayed on the homepage.', 'kenda-custom' ); ?>
			</p>

			<table class="form-table" role="presentation">

				<?php

				// In Kenda's Words.
				kenda_admin_text_row(
					'words_heading',
					__( 'In Kenda’s Words - Heading', 'kenda-custom' ),
					$options
				);

				kenda_admin_text_row(
					'words_quote',
					__( 'In Kenda’s Words - Quote', 'kenda-custom' ),
					$options,
					'textarea'
				);

				kenda_admin_text_row(
					'words_author',
					__( 'In Kenda’s Words - Author', 'kenda-custom' ),
					$options
				);


				// Your Voice. Your Vote.
				kenda_admin_text_row(
					'voice_heading',
					__( 'Your Voice - Heading', 'kenda-custom' ),
					$options
				);

				kenda_admin_text_row(
					'voice_subheading',
					__( 'Your Voice - Subheading', 'kenda-custom' ),
					$options
				);

				kenda_admin_text_row(
					'voice_body',
					__( 'Your Voice - Description', 'kenda-custom' ),
					$options,
					'textarea'
				);


				// Help Bring Accountability Back.
				kenda_admin_text_row(
					'support_heading',
					__( 'Support Campaign - Heading', 'kenda-custom' ),
					$options
				);

				kenda_admin_text_row(
					'support_label',
					__( 'Support Campaign - CTA Label', 'kenda-custom' ),
					$options
				);

				kenda_admin_text_row(
					'support_description',
					__( 'Support Campaign - Description', 'kenda-custom' ),
					$options,
					'textarea'
				);

				?>

			</table>

			<h2 class="title">
				<?php esc_html_e( 'Campaign Actions', 'kenda-custom' ); ?>
			</h2>

			<p class="description">
				<?php esc_html_e( 'Edit donation, volunteer, and campaign text-update content displayed on the homepage.', 'kenda-custom' ); ?>
			</p>

			<!-- Donation Section -->
			<h3 class="title">
				<?php esc_html_e( 'Donation', 'kenda-custom' ); ?>
			</h3>

			<table class="form-table" role="presentation">
				<?php
				kenda_admin_text_row(
					'donation_amounts',
					__( 'Donation Amounts', 'kenda-custom' ),
					$options,
					'textarea'
				);
				?>

				<tr>
					<th scope="row">
						<label>
							<?php esc_html_e( 'Amount Format', 'kenda-custom' ); ?>
						</label>
					</th>

					<td>
						<p class="description">
							<?php esc_html_e( 'Enter one amount per line. Example: 25, 50, 100, 250, OTHER.', 'kenda-custom' ); ?>
						</p>
					</td>
				</tr>

				<?php
				kenda_admin_text_row(
					'donate_button_text',
					__( 'Donate Button Text', 'kenda-custom' ),
					$options
				);

				kenda_admin_text_row(
					'donate_button_url',
					__( 'Donate Button URL', 'kenda-custom' ),
					$options,
					'url'
				);
				?>
			</table>


			<!-- Join the Team Section -->
			<h3 class="title">
				<?php esc_html_e( 'Join the Team', 'kenda-custom' ); ?>
			</h3>

			<table class="form-table" role="presentation">
				<?php
				kenda_admin_text_row(
					'team_heading',
					__( 'Heading', 'kenda-custom' ),
					$options
				);

				kenda_admin_text_row(
					'team_description',
					__( 'Description', 'kenda-custom' ),
					$options,
					'textarea'
				);

				kenda_admin_text_row(
					'team_button_text',
					__( 'Button Text', 'kenda-custom' ),
					$options
				);

				kenda_admin_text_row(
					'team_button_url',
					__( 'Button URL', 'kenda-custom' ),
					$options,
					'url'
				);
				?>
			</table>


			<!-- Campaign Text Updates -->
			<h3 class="title">
				<?php esc_html_e( 'Campaign Text Updates', 'kenda-custom' ); ?>
			</h3>

			<table class="form-table" role="presentation">
				<?php
				kenda_admin_text_row(
					'text_updates_heading',
					__( 'Heading', 'kenda-custom' ),
					$options
				);

				kenda_admin_text_row(
					'text_updates_name_label',
					__( 'Name Field Label', 'kenda-custom' ),
					$options
				);

				kenda_admin_text_row(
					'text_updates_mobile_label',
					__( 'Mobile Field Label', 'kenda-custom' ),
					$options
				);

				kenda_admin_text_row(
					'text_updates_zip_label',
					__( 'Zip Code Field Label', 'kenda-custom' ),
					$options
				);

				kenda_admin_text_row(
					'text_updates_disclaimer',
					__( 'SMS Disclaimer', 'kenda-custom' ),
					$options,
					'textarea'
				);

				kenda_admin_text_row(
					'text_updates_button_text',
					__( 'Submit Button Text', 'kenda-custom' ),
					$options
				);

				kenda_admin_text_row(
					'text_updates_form_action',
					__( 'Form Action URL', 'kenda-custom' ),
					$options,
					'url'
				);
				?>
			</table>
			<h2 class="title"><?php esc_html_e( 'Get Involved', 'kenda-custom' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php
				kenda_admin_text_row( 'involved_eyebrow', __( 'Section Label', 'kenda-custom' ), $options );
				kenda_admin_text_row( 'involved_heading', __( 'Section Heading', 'kenda-custom' ), $options );
				kenda_admin_text_row( 'involved_body', __( 'Content', 'kenda-custom' ), $options, 'textarea' );
				kenda_admin_text_row( 'involved_cta_text', __( 'Button Text', 'kenda-custom' ), $options );
				kenda_admin_text_row( 'involved_cta_url', __( 'Button URL', 'kenda-custom' ), $options, 'url' );
				?>
			</table>

			<h2 class="title"><?php esc_html_e( 'Support / CTA', 'kenda-custom' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php
				kenda_admin_text_row( 'cta_eyebrow', __( 'Section Label', 'kenda-custom' ), $options );
				kenda_admin_text_row( 'cta_heading', __( 'CTA Heading', 'kenda-custom' ), $options );
				kenda_admin_text_row( 'cta_body', __( 'CTA Description', 'kenda-custom' ), $options, 'textarea' );
				kenda_admin_text_row( 'cta_button_text', __( 'Button Text', 'kenda-custom' ), $options );
				kenda_admin_text_row( 'cta_button_url', __( 'Button URL', 'kenda-custom' ), $options, 'url' );
				kenda_admin_media_field( 'cta_qr_image', __( 'Donate QR Image (optional)', 'kenda-custom' ), $options['cta_qr_image'] ?? 0 );
				?>
			</table>

			<h2 class="title"><?php esc_html_e( 'Contact Section', 'kenda-custom' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php
				kenda_admin_text_row( 'contact_eyebrow', __( 'Section Label', 'kenda-custom' ), $options );
				kenda_admin_text_row( 'contact_heading', __( 'Contact Heading', 'kenda-custom' ), $options );
				kenda_admin_text_row( 'contact_body', __( 'Contact Introduction', 'kenda-custom' ), $options, 'textarea' );
				?>
			</table>

			<?php submit_button( __( 'Save Homepage Content', 'kenda-custom' ) ); ?>
		</form>
	</div>
	<?php
	
}

/**
 * @param array<string,mixed> $input Raw input.
 * @return array<string,mixed>
 */
function kenda_sanitize_homepage_settings( array $input ): array {
	$media_keys = array( 'hero_video', 'hero_poster', 'about_image', 'vision_image', 'cta_qr_image' );
	$url_keys   = array( 'hero_primary_url', 'hero_secondary_url', 'involved_cta_url', 'cta_button_url' );
	$text_keys  = array(
		'hero_elect',
		'hero_eyebrow',
		'hero_title',
		'hero_credit_line',
		'hero_website_line',
		'intro_eyebrow',
		'intro_heading',
		'about_eyebrow',
		'about_heading',
		'experience_eyebrow',
		'experience_heading',
		'priorities_eyebrow',
		'priorities_heading',
		'vision_eyebrow',
		'vision_heading',
		'involved_eyebrow',
		'involved_heading',
		'involved_cta_text',
		'cta_eyebrow',
		'cta_heading',
		'cta_button_text',
		'contact_eyebrow',
		'contact_heading',
		'words_heading',
		'words_author',

		'voice_heading',
		'voice_subheading',

		'support_heading',
		'support_label',
		'donate_button_text',
		'team_heading',
		'team_button_text',
		'text_updates_heading',
		'text_updates_name_label',
		'text_updates_mobile_label',
		'text_updates_zip_label',
		'text_updates_button_text',
	);
	$area_keys = array(
		'hero_subtitle',
		'hero_services_line',
		'hero_description',
		'intro_lead',
		'intro_body',
		'about_body',
		'about_facts',
		'experience_intro',
		'priorities_intro',
		'vision_body',
		'involved_body',
		'cta_body',
		'contact_body',
		'words_quote',
		'voice_body',
		'support_description',
		'donation_amounts',
		'team_description',
		'text_updates_disclaimer',
	);

	$out = array();
	foreach ( $input as $key => $value ) {
		$key = sanitize_key( (string) $key );
		if ( in_array( $key, $media_keys, true ) ) {
			$out[ $key ] = absint( $value );
		} elseif ( in_array( $key, $url_keys, true ) ) {
			$out[ $key ] = esc_url_raw( (string) $value );
		} elseif ( in_array( $key, $area_keys, true ) ) {
			$out[ $key ] = sanitize_textarea_field( (string) $value );
		} elseif ( in_array( $key, $text_keys, true ) ) {
			$out[ $key ] = sanitize_text_field( (string) $value );
		}
	}
	return $out;
}

function kenda_render_site_settings_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( isset( $_POST['kenda_site_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['kenda_site_nonce'] ) ), 'kenda_save_site' ) ) {
		$raw   = wp_unslash( $_POST['kenda_site_settings'] ?? array() );
		$clean = kenda_sanitize_site_settings( is_array( $raw ) ? $raw : array() );
		update_option( 'kenda_site_settings', $clean );
		echo '<div class="notice notice-success"><p>' . esc_html__( 'Site settings saved.', 'kenda-custom' ) . '</p></div>';
	}

	$options = get_option( 'kenda_site_settings', array() );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Site Settings', 'kenda-custom' ); ?></h1>
		<form method="post">
			<?php wp_nonce_field( 'kenda_save_site', 'kenda_site_nonce' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="site_name"><?php esc_html_e( 'Site Name', 'kenda-custom' ); ?></label></th>
					<td><input type="text" id="site_name" name="kenda_site_settings[site_name]" value="<?php echo esc_attr( (string) ( $options['site_name'] ?? '' ) ); ?>" class="regular-text" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="contact_email"><?php esc_html_e( 'Contact Email', 'kenda-custom' ); ?></label></th>
					<td><input type="email" id="contact_email" name="kenda_site_settings[contact_email]" value="<?php echo esc_attr( (string) ( $options['contact_email'] ?? '' ) ); ?>" class="regular-text" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="contact_phone"><?php esc_html_e( 'Contact Phone', 'kenda-custom' ); ?></label></th>
					<td><input type="text" id="contact_phone" name="kenda_site_settings[contact_phone]" value="<?php echo esc_attr( (string) ( $options['contact_phone'] ?? '' ) ); ?>" class="regular-text" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="donation_url"><?php esc_html_e( 'Donation URL', 'kenda-custom' ); ?></label></th>
					<td><input type="url" id="donation_url" name="kenda_site_settings[donation_url]" value="<?php echo esc_attr( (string) ( $options['donation_url'] ?? '' ) ); ?>" class="large-text" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="header_cta_text"><?php esc_html_e( 'Header CTA Text', 'kenda-custom' ); ?></label></th>
					<td><input type="text" id="header_cta_text" name="kenda_site_settings[header_cta_text]" value="<?php echo esc_attr( (string) ( $options['header_cta_text'] ?? '' ) ); ?>" class="regular-text" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="header_cta_url"><?php esc_html_e( 'Header CTA URL', 'kenda-custom' ); ?></label></th>
					<td><input type="url" id="header_cta_url" name="kenda_site_settings[header_cta_url]" value="<?php echo esc_attr( (string) ( $options['header_cta_url'] ?? '' ) ); ?>" class="large-text" /></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Social Links', 'kenda-custom' ); ?></th>
					<td>
						<p>
							<label>
								Facebook 
								<input type="url" name="kenda_site_settings[facebook_url]" value="<?php echo esc_attr( (string) ( $options['facebook_url'] ?? '' ) ); ?>" class="large-text" />
							</label>
						</p>
						<p>
							<label>Instagram 
								<input type="url" name="kenda_site_settings[instagram_url]" value="<?php echo esc_attr( (string) ( $options['instagram_url'] ?? '' ) ); ?>" class="large-text" />
							</label>
						</p>
						<p>
							<label>LinkedIn 
								<input type="url" name="kenda_site_settings[linkedin_url]" value="<?php echo esc_attr( (string) ( $options['linkedin_url'] ?? '' ) ); ?>" class="large-text" />
							</label>
						</p>
						<p>
							<label>TikTok 
								<input type="url" name="kenda_site_settings[tiktok_url]" value="<?php echo esc_attr( (string) ( $options['tiktok_url'] ?? '' ) ); ?>" class="large-text" />
							</label>
						</p>
						<p>
							<label>YouTube 
								<input type="url" name="kenda_site_settings[youtube_url]" value="<?php echo esc_attr( (string) ( $options['youtube_url'] ?? '' ) ); ?>" class="large-text" />
							</label>
						</p>
							<p>
							<label>X 
								<input type="url" name="kenda_site_settings[x_url]" value="<?php echo esc_attr( (string) ( $options['x_url'] ?? '' ) ); ?>" class="large-text" />
							</label>
						</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="footer_disclaimer"><?php esc_html_e( 'Footer Disclaimer', 'kenda-custom' ); ?></label></th>
					<td><textarea id="footer_disclaimer" name="kenda_site_settings[footer_disclaimer]" rows="2" class="large-text"><?php echo esc_textarea( (string) ( $options['footer_disclaimer'] ?? '' ) ); ?></textarea></td>
				</tr>
				<tr>
					<th scope="row"><label for="copyright_text"><?php esc_html_e( 'Copyright', 'kenda-custom' ); ?></label></th>
					<td><input type="text" id="copyright_text" name="kenda_site_settings[copyright_text]" value="<?php echo esc_attr( (string) ( $options['copyright_text'] ?? '' ) ); ?>" class="large-text" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="newsletter_heading"><?php esc_html_e( 'Newsletter Heading', 'kenda-custom' ); ?></label></th>
					<td><input type="text" id="newsletter_heading" name="kenda_site_settings[newsletter_heading]" value="<?php echo esc_attr( (string) ( $options['newsletter_heading'] ?? '' ) ); ?>" class="regular-text" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="newsletter_description"><?php esc_html_e( 'Newsletter Description', 'kenda-custom' ); ?></label></th>
					<td><textarea id="newsletter_description" name="kenda_site_settings[newsletter_description]" rows="2" class="large-text"><?php echo esc_textarea( (string) ( $options['newsletter_description'] ?? '' ) ); ?></textarea></td>
				</tr>
			</table>
			<?php submit_button( __( 'Save Site Settings', 'kenda-custom' ) ); ?>
		</form>
	</div>
	<?php
}

/**
 * @param array<string,mixed> $input Raw input.
 * @return array<string,mixed>
 */
function kenda_sanitize_site_settings( array $input ): array {
	$map = array(
		'site_name'              => 'sanitize_text_field',
		'contact_email'          => 'sanitize_email',
		'contact_phone'          => 'sanitize_text_field',
		'donation_url'           => 'esc_url_raw',
		'header_cta_text'        => 'sanitize_text_field',
		'header_cta_url'         => 'esc_url_raw',
		'facebook_url'           => 'esc_url_raw',
		'instagram_url'          => 'esc_url_raw',
		'linkedin_url'          => 'esc_url_raw',
		'tiktok_url'          => 'esc_url_raw',
		'youtube_url'          => 'esc_url_raw',
		'x_url'            => 'esc_url_raw',
		'footer_disclaimer'      => 'sanitize_textarea_field',
		'copyright_text'         => 'sanitize_text_field',
		'newsletter_heading'     => 'sanitize_text_field',
		'newsletter_description' => 'sanitize_textarea_field',
	);
	$out = array();
	foreach ( $map as $key => $callback ) {
		if ( isset( $input[ $key ] ) ) {
			$out[ $key ] = $callback( (string) $input[ $key ] );
		}
	}
	return $out;
}
