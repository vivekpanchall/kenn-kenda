<?php

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/**
 * Create text signup table.
 */
function kenda_create_text_signups_table(): void {

    global $wpdb;

    $table_name = $wpdb->prefix . 'kenda_text_signups';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE {$table_name} (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        mobile VARCHAR(50) NOT NULL,
        zip_code VARCHAR(20) NOT NULL,
        sms_consent TINYINT(1) NOT NULL DEFAULT 0,
        consented_at DATETIME NULL,
        created_at DATETIME NOT NULL,
        PRIMARY KEY (id),
        KEY mobile (mobile),
        KEY created_at (created_at)
    ) {$charset_collate};";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    dbDelta( $sql );
}

/**
 * Handle text update signup.
 */
function kenda_handle_text_signup(): void {

    if (
        ! isset( $_POST['kenda_text_signup_nonce'] ) ||
        ! wp_verify_nonce(
            sanitize_text_field(
                wp_unslash( $_POST['kenda_text_signup_nonce'] )
            ),
            'kenda_text_signup'
        )
    ) {
        wp_die(
            esc_html__( 'Security check failed.', 'kenda-custom' ),
            esc_html__( 'Error', 'kenda-custom' ),
            array(
                'response' => 403,
            )
        );
    }

    $name = sanitize_text_field(
        wp_unslash( $_POST['name'] ?? '' )
    );

    $mobile = sanitize_text_field(
        wp_unslash( $_POST['mobile'] ?? '' )
    );

    $zip_code = sanitize_text_field(
        wp_unslash( $_POST['zip_code'] ?? '' )
    );

    $sms_consent = isset( $_POST['sms_consent'] )
        ? 1
        : 0;

    /*
     * Validate required fields.
     */
    if (
        '' === $name ||
        '' === $mobile ||
        '' === $zip_code ||
        1 !== $sms_consent
    ) {
        wp_die(
            esc_html__(
                'Please complete all required fields and provide SMS consent.',
                'kenda-custom'
            ),
            esc_html__( 'Signup Error', 'kenda-custom' ),
            array(
                'response' => 422,
            )
        );
    }

    global $wpdb;

    $table_name = $wpdb->prefix . 'kenda_text_signups';

    /*
     * Store signup.
     */
    $inserted = $wpdb->insert(
        $table_name,
        array(
            'name'         => $name,
            'mobile'       => $mobile,
            'zip_code'     => $zip_code,
            'sms_consent'  => $sms_consent,
            'consented_at' => current_time( 'mysql' ),
            'created_at'   => current_time( 'mysql' ),
        ),
        array(
            '%s',
            '%s',
            '%s',
            '%d',
            '%s',
            '%s',
        )
    );

    if ( false === $inserted ) {

        wp_die(
            esc_html__(
                'Unable to save your signup. Please try again.',
                'kenda-custom'
            ),
            esc_html__( 'Signup Error', 'kenda-custom' ),
            array(
                'response' => 500,
            )
        );
    }

    /*
     * Redirect back to homepage with success status.
     */
    $redirect_url = wp_get_referer();

    if ( ! $redirect_url ) {
        $redirect_url = home_url( '/' );
    }

    $redirect_url = add_query_arg(
        'text_signup',
        'success',
        $redirect_url
    );

    wp_safe_redirect( $redirect_url );

    exit;
}

add_action(
    'admin_post_nopriv_kenda_text_signup',
    'kenda_handle_text_signup'
);

add_action(
    'admin_post_kenda_text_signup',
    'kenda_handle_text_signup'
);

add_action(
    'after_setup_theme',
    'kenda_create_text_signups_table'
);