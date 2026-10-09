<?php
/**
 * Experience and priority post types.
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'init',
	function (): void {
		register_post_type(
			'kenda_experience',
			array(
				'labels'              => array(
					'name'          => __( 'Experience', 'kenda-custom' ),
					'singular_name' => __( 'Experience Entry', 'kenda-custom' ),
					'add_new_item'  => __( 'Add Experience', 'kenda-custom' ),
				),
				'public'              => false,
				'show_ui'             => true,
				'show_in_menu'        => 'kenda-site',
				'menu_position'       => 25,
				'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
				'has_archive'         => false,
				'capability_type'     => 'post',
				'menu_icon'           => 'dashicons-awards',
			)
		);

		register_post_type(
			'kenda_priority',
			array(
				'labels'              => array(
					'name'          => __( 'Priorities', 'kenda-custom' ),
					'singular_name' => __( 'Priority', 'kenda-custom' ),
					'add_new_item'  => __( 'Add Priority', 'kenda-custom' ),
				),
				'public'              => false,
				'show_ui'             => true,
				'show_in_menu'        => 'kenda-site',
				'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
				'has_archive'         => false,
				'capability_type'     => 'post',
				'menu_icon'           => 'dashicons-flag',
			)
		);

		register_post_type(
			'kenda_inquiry',
			array(
				'labels'              => array(
					'name'          => __( 'Contact Submissions', 'kenda-custom' ),
					'singular_name' => __( 'Submission', 'kenda-custom' ),
				),
				'public'              => false,
				'show_ui'             => true,
				'show_in_menu'        => 'kenda-site',
				'supports'            => array( 'title', 'editor' ),
				'capability_type'     => 'post',
				'menu_icon'           => 'dashicons-email',
			)
		);
	}
);

add_action(
	'add_meta_boxes',
	function (): void {
		add_meta_box(
			'kenda_experience_details',
			__( 'Experience Details', 'kenda-custom' ),
			'kenda_render_experience_meta_box',
			'kenda_experience',
			'normal',
			'high'
		);

		add_meta_box(
			'kenda_priority_details',
			__( 'Priority Details', 'kenda-custom' ),
			'kenda_render_priority_meta_box',
			'kenda_priority',
			'normal',
			'high'
		);
	}
);

/**
 * @param WP_Post $post Post object.
 */
function kenda_render_experience_meta_box( WP_Post $post ): void {
	wp_nonce_field( 'kenda_experience_meta', 'kenda_experience_nonce' );
	$year         = get_post_meta( $post->ID, 'experience_year', true );
	$organization = get_post_meta( $post->ID, 'experience_organization', true );
	?>
	<p>
		<label for="experience_year"><strong><?php esc_html_e( 'Year / Period', 'kenda-custom' ); ?></strong></label><br />
		<input type="text" id="experience_year" name="experience_year" value="<?php echo esc_attr( (string) $year ); ?>" class="widefat" />
	</p>
	<p>
		<label for="experience_organization"><strong><?php esc_html_e( 'Organization', 'kenda-custom' ); ?></strong></label><br />
		<input type="text" id="experience_organization" name="experience_organization" value="<?php echo esc_attr( (string) $organization ); ?>" class="widefat" />
	</p>
	<?php
}

/**
 * @param WP_Post $post Post object.
 */
function kenda_render_priority_meta_box( WP_Post $post ): void {
	wp_nonce_field( 'kenda_priority_meta', 'kenda_priority_nonce' );
	$short = get_post_meta( $post->ID, 'priority_short_description', true );
	$num   = get_post_meta( $post->ID, 'priority_number', true );
	$popup = get_post_meta( $post->ID, 'priority_popup_content', true );
	?>
	<p>
		<label for="priority_number"><strong><?php esc_html_e( 'Display Number (e.g. 01)', 'kenda-custom' ); ?></strong></label><br />
		<input type="text" id="priority_number" name="priority_number" value="<?php echo esc_attr( (string) $num ); ?>" class="small-text" />
	</p>
	<p>
		<label for="priority_short_description"><strong><?php esc_html_e( 'Short Description', 'kenda-custom' ); ?></strong></label><br />
		<textarea id="priority_short_description" name="priority_short_description" rows="3" class="widefat"><?php echo esc_textarea( (string) $short ); ?></textarea>
	</p>
	<p>
		<label for="priority_popup_content"><strong><?php esc_html_e( 'Popup Content', 'kenda-custom' ); ?></strong></label><br />
		<span class="description"><?php esc_html_e( 'Shown in the Learn More modal on the homepage. Leave empty to hide the button.', 'kenda-custom' ); ?></span>
	</p>
	<?php
	wp_editor(
		(string) $popup,
		'priority_popup_content',
		array(
			'textarea_name' => 'priority_popup_content',
			'textarea_rows' => 12,
			'media_buttons' => true,
		)
	);
}

add_action(
	'save_post_kenda_experience',
	function ( int $post_id ): void {
		if ( ! isset( $_POST['kenda_experience_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['kenda_experience_nonce'] ) ), 'kenda_experience_meta' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		update_post_meta( $post_id, 'experience_year', sanitize_text_field( wp_unslash( $_POST['experience_year'] ?? '' ) ) );
		update_post_meta( $post_id, 'experience_organization', sanitize_text_field( wp_unslash( $_POST['experience_organization'] ?? '' ) ) );
	}
);

add_action(
	'save_post_kenda_priority',
	function ( int $post_id ): void {
		if ( ! isset( $_POST['kenda_priority_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['kenda_priority_nonce'] ) ), 'kenda_priority_meta' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		update_post_meta( $post_id, 'priority_short_description', sanitize_textarea_field( wp_unslash( $_POST['priority_short_description'] ?? '' ) ) );
		update_post_meta( $post_id, 'priority_number', sanitize_text_field( wp_unslash( $_POST['priority_number'] ?? '' ) ) );
		update_post_meta( $post_id, 'priority_popup_content', wp_kses_post( wp_unslash( $_POST['priority_popup_content'] ?? '' ) ) );
	}
);
