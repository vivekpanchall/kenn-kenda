<?php
/**
 * Contact form and newsletter AJAX handlers.
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_ajax_kenda_contact', 'kenda_handle_contact' );
add_action( 'wp_ajax_nopriv_kenda_contact', 'kenda_handle_contact' );
add_action( 'wp_ajax_kenda_newsletter', 'kenda_handle_newsletter' );
add_action( 'wp_ajax_nopriv_kenda_newsletter', 'kenda_handle_newsletter' );

function kenda_handle_contact(): void {
	check_ajax_referer( 'kenda_contact', 'nonce' );

	if ( ! empty( $_POST['company'] ) ) {
		wp_send_json_error( array( 'message' => __( 'Unable to send message.', 'kenda-custom' ) ), 400 );
	}

	$name    = sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) );
	$email   = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
	$source  = sanitize_text_field( wp_unslash( $_POST['source'] ?? '' ) );
	$message = sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) );

	if ( '' === $name || '' === $email || ! is_email( $email ) || '' === $message ) {
		wp_send_json_error( array( 'message' => __( 'Please complete all required fields.', 'kenda-custom' ) ), 422 );
	}

	$attachment_note = '';
	if ( ! empty( $_FILES['attachment']['name'] ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		$upload = wp_handle_upload(
			$_FILES['attachment'],
			array(
				'test_form' => false,
				'mimes'     => array(
					'pdf'  => 'application/pdf',
					'doc'  => 'application/msword',
					'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
					'jpg'  => 'image/jpeg',
					'jpeg' => 'image/jpeg',
					'png'  => 'image/png',
				),
			)
		);
		if ( isset( $upload['url'] ) ) {
			$attachment_note = "\n\nAttachment: " . esc_url_raw( $upload['url'] );
		}
	}

	$to      = kenda_site( 'contact_email', get_option( 'admin_email' ) );
	$subject = sprintf(
		/* translators: %s: sender name */
		__( 'Campaign contact from %s', 'kenda-custom' ),
		$name
	);
	$body    = "Name: {$name}\nEmail: {$email}\nSource: {$source}\n\n{$message}{$attachment_note}";
	$headers = array( 'Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $name . ' <' . $email . '>' );

	$sent = wp_mail( $to, $subject, $body, $headers );

	wp_insert_post(
		array(
			'post_type'    => 'kenda_inquiry',
			'post_status'  => 'private',
			'post_title'   => $name . ' — ' . current_time( 'mysql' ),
			'post_content' => wp_kses_post( "<p><strong>Email:</strong> {$email}<br><strong>Source:</strong> {$source}</p><p>" . nl2br( esc_html( $message ) ) . '</p>' ),
		)
	);

	if ( ! $sent ) {
		wp_send_json_error( array( 'message' => __( 'Message saved but email could not be sent. Please call the campaign.', 'kenda-custom' ) ), 500 );
	}

	wp_send_json_success(
		array(
			'message' => kenda_home( 'contact_success_message', __( 'Thank you for reaching out. Our team will respond soon.', 'kenda-custom' ) ),
		)
	);
}

function kenda_handle_newsletter(): void {
	check_ajax_referer( 'kenda_contact', 'nonce' );

	if ( ! empty( $_POST['company'] ) ) {
		wp_send_json_error( array( 'message' => __( 'Unable to subscribe.', 'kenda-custom' ) ), 400 );
	}

	$email = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
	if ( ! is_email( $email ) ) {
		wp_send_json_error( array( 'message' => __( 'Please enter a valid email address.', 'kenda-custom' ) ), 422 );
	}

	$list = get_option( 'kenda_newsletter_emails', array() );
	if ( ! is_array( $list ) ) {
		$list = array();
	}
	if ( ! in_array( $email, $list, true ) ) {
		$list[] = $email;
		update_option( 'kenda_newsletter_emails', $list, false );
	}

	wp_send_json_success(
		array(
			'message' => __( 'Thank you for joining the campaign community.', 'kenda-custom' ),
		)
	);
}
