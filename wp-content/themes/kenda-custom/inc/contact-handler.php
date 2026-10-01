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

/*
|--------------------------------------------------------------------------
| AJAX Actions
|--------------------------------------------------------------------------
*/

add_action( 'wp_ajax_kenda_contact', 'kenda_handle_contact' );
add_action( 'wp_ajax_nopriv_kenda_contact', 'kenda_handle_contact' );

add_action( 'wp_ajax_kenda_newsletter', 'kenda_handle_newsletter' );
add_action( 'wp_ajax_nopriv_kenda_newsletter', 'kenda_handle_newsletter' );


/*
|--------------------------------------------------------------------------
| Contact Form Handler
|--------------------------------------------------------------------------
*/

function kenda_handle_contact(): void {

	/*
	 * Verify AJAX nonce.
	 */
	check_ajax_referer( 'kenda_contact', 'nonce' );


	/*
	 * Honeypot spam protection.
	 */
	if ( ! empty( $_POST['company'] ) ) {

		wp_send_json_error(
			array(
				'message' => __( 'Unable to send message.', 'kenda-custom' ),
			),
			400
		);
	}


	/*
	 * Sanitize form fields.
	 */
	$name = sanitize_text_field(
		wp_unslash( $_POST['name'] ?? '' )
	);

	$email = sanitize_email(
		wp_unslash( $_POST['email'] ?? '' )
	);

	$source = sanitize_text_field(
		wp_unslash( $_POST['source'] ?? '' )
	);

	$message = sanitize_textarea_field(
		wp_unslash( $_POST['message'] ?? '' )
	);


	/*
	 * Validate required fields.
	 */
	if (
		'' === $name ||
		'' === $email ||
		! is_email( $email ) ||
		'' === $message
	) {

		wp_send_json_error(
			array(
				'message' => __( 'Please complete all required fields.', 'kenda-custom' ),
			),
			422
		);
	}


	/*
	|--------------------------------------------------------------------------
	| Handle Attachment
	|--------------------------------------------------------------------------
	*/

	$attachments = array();

	if (
		isset( $_FILES['attachment'] ) &&
		! empty( $_FILES['attachment']['name'] )
	) {

		$file = $_FILES['attachment'];

		/*
		 * Maximum file size: 10 MB.
		 */
		$max_size = 10 * 1024 * 1024;

		if ( ! empty( $file['size'] ) && $file['size'] > $max_size ) {

			wp_send_json_error(
				array(
					'message' => __( 'The attachment must be smaller than 10 MB.', 'kenda-custom' ),
				),
				422
			);
		}


		/*
		 * Allowed MIME types.
		 */
		$allowed_mimes = array(
			'pdf'  => 'application/pdf',
			'doc'  => 'application/msword',
			'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'jpg'  => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'png'  => 'image/png',
		);


		/*
		 * Verify actual file type.
		 */
		$file_type = wp_check_filetype_and_ext(
			$file['tmp_name'],
			$file['name'],
			$allowed_mimes
		);

		if ( empty( $file_type['ext'] ) || empty( $file_type['type'] ) ) {

			wp_send_json_error(
				array(
					'message' => __( 'The selected attachment type is not allowed.', 'kenda-custom' ),
				),
				422
			);
		}


		/*
		 * Upload file to WordPress uploads directory.
		 */
		require_once ABSPATH . 'wp-admin/includes/file.php';

		$upload = wp_handle_upload(
			$file,
			array(
				'test_form' => false,
				'mimes'     => $allowed_mimes,
			)
		);


		/*
		 * Check upload error.
		 */
		if ( isset( $upload['error'] ) ) {

			wp_send_json_error(
				array(
					'message' => __( 'The attachment could not be uploaded. Please try again.', 'kenda-custom' ),
				),
				500
			);
		}


		/*
		 * Add uploaded physical file path
		 * as email attachment.
		 */
		if ( ! empty( $upload['file'] ) ) {
			$attachments[] = $upload['file'];
		}
	}


	/*
	|--------------------------------------------------------------------------
	| Admin Email
	|--------------------------------------------------------------------------
	*/

	$to = kenda_site(
		'contact_email',
		get_option( 'admin_email' )
	);


	/*
	 * Make sure the email address is valid.
	 */
	if ( ! is_email( $to ) ) {

		$to = get_option( 'admin_email' );
	}


	/*
	 * Email subject.
	 */
	$subject = sprintf(
		/* translators: %s: sender name */
		__( 'Campaign contact from %s', 'kenda-custom' ),
		$name
	);


	/*
	 * Email body.
	 */
	$body  = "You have received a new contact form submission.\n\n";

	$body .= "Name: " . $name . "\n";
	$body .= "Email: " . $email . "\n";

	if ( '' !== $source ) {
		$body .= "How did they hear about us: " . $source . "\n";
	}

	$body .= "\nMessage:\n";
	$body .= $message . "\n";

	if ( ! empty( $attachments ) ) {
		$body .= "\nAttachment: The submitted file is attached to this email.\n";
	}


	/*
	 * Email headers.
	 *
	 * Use the website/admin email as the sender
	 * and visitor email as Reply-To.
	 */
	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $name . ' <' . $email . '>',
	);


	/*
	|--------------------------------------------------------------------------
	| Send Email
	|--------------------------------------------------------------------------
	*/

	$sent = wp_mail(
		$to,
		$subject,
		$body,
		$headers,
		$attachments
	);


	/*
	|--------------------------------------------------------------------------
	| Save Inquiry in WordPress
	|--------------------------------------------------------------------------
	*/

	wp_insert_post(
		array(
			'post_type'    => 'kenda_inquiry',
			'post_status'  => 'private',
			'post_title'   => $name . ' — ' . current_time( 'mysql' ),
			'post_content' => wp_kses_post(
				'<p><strong>Email:</strong> ' .
				esc_html( $email ) .
				'<br><strong>Source:</strong> ' .
				esc_html( $source ) .
				'</p><p>' .
				nl2br( esc_html( $message ) ) .
				'</p>'
			),
		)
	);


	/*
	|--------------------------------------------------------------------------
	| Email Result
	|--------------------------------------------------------------------------
	*/

	if ( ! $sent ) {

		wp_send_json_error(
			array(
				'message' => __(
					'Message saved but email could not be sent. Please call the campaign.',
					'kenda-custom'
				),
			),
			500
		);
	}


	/*
	 * Successful submission.
	 */
	wp_send_json_success(
		array(
			'message' => kenda_home(
				'contact_success_message',
				__(
					'Thank you for reaching out. Our team will respond soon.',
					'kenda-custom'
				)
			),
		)
	);
}


/*
|--------------------------------------------------------------------------
| Newsletter Handler
|--------------------------------------------------------------------------
*/

function kenda_handle_newsletter(): void {

	check_ajax_referer( 'kenda_contact', 'nonce' );


	/*
	 * Honeypot spam protection.
	 */
	if ( ! empty( $_POST['company'] ) ) {

		wp_send_json_error(
			array(
				'message' => __( 'Unable to subscribe.', 'kenda-custom' ),
			),
			400
		);
	}


	$email = sanitize_email(
		wp_unslash( $_POST['email'] ?? '' )
	);


	/*
	 * Validate email.
	 */
	if ( ! is_email( $email ) ) {

		wp_send_json_error(
			array(
				'message' => __( 'Please enter a valid email address.', 'kenda-custom' ),
			),
			422
		);
	}


	/*
	 * Get existing newsletter subscribers.
	 */
	$list = get_option( 'kenda_newsletter_emails', array() );

	if ( ! is_array( $list ) ) {
		$list = array();
	}


	/*
	 * Add email if not already subscribed.
	 */
	if ( ! in_array( $email, $list, true ) ) {

		$list[] = $email;

		update_option(
			'kenda_newsletter_emails',
			$list,
			false
		);
	}


	wp_send_json_success(
		array(
			'message' => __(
				'Thank you for joining the campaign community.',
				'kenda-custom'
			),
		)
	);
}