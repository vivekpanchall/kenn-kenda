<?php
/**
 * Contact form section.
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);

$phone               = kenda_site( 'contact_phone' );
$email               = kenda_site( 'contact_email' );
$tel                 = preg_replace( '/\D+/', '', (string) $phone );
$message_placeholder = __( 'Tell us more about how you would like to get involved.', 'kenda-custom' );
?>
<section class="section section--contact" id="contact" data-animate>
	<div class="section__inner section__inner--contact">
		<header class="contact-section__header">
			<?php if ( kenda_home( 'contact_eyebrow' ) ) : ?>
				<p class="eyebrow"><?php echo esc_html( kenda_home( 'contact_eyebrow' ) ); ?></p>
			<?php endif; ?>
			<?php if ( kenda_home( 'contact_heading' ) ) : ?>
				<h2 class="display-md contact-section__title"><?php echo esc_html( kenda_home( 'contact_heading' ) ); ?></h2>
			<?php endif; ?>
			<?php if ( kenda_home( 'contact_body' ) ) : ?>
				<p class="contact-section__intro"><?php echo esc_html( kenda_home( 'contact_body' ) ); ?></p>
			<?php endif; ?>
		</header>

<div class="k-contact">

    <!-- Contact Header -->
    <div class="k-contact__header">

        <div class="k-contact__intro">

            <span class="k-contact__eyebrow">
                <?php esc_html_e( 'Get In Touch', 'kenda-custom' ); ?>
            </span>

            <h3 class="k-contact__title">
                <?php esc_html_e( 'Let’s Start a Conversation', 'kenda-custom' ); ?>
            </h3>

            <p class="k-contact__description">
                <?php
                esc_html_e(
                    'Have a question, idea, or want to connect with the campaign? Send us a message and our team will get back to you.',
                    'kenda-custom'
                );
                ?>
            </p>

        </div>

        <div class="k-contact__details">

            <?php if ( $phone ) : ?>

                <a
                    class="k-contact__detail"
                    href="tel:<?php echo esc_attr( $tel ); ?>"
                >
                    <span class="k-contact__detail-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2
                                19.79 19.79 0 0 1-8.63-3.07
                                19.5 19.5 0 0 1-6-6
                                19.79 19.79 0 0 1-3.07-8.67
                                A2 2 0 0 1 4.11 2h3
                                a2 2 0 0 1 2 1.72
                                12.84 12.84 0 0 0 .7 2.81
                                2 2 0 0 1-.45 2.11L8.09 9.91
                                a16 16 0 0 0 6 6l1.27-1.27
                                a2 2 0 0 1 2.11-.45
                                12.84 12.84 0 0 0 2.81.7
                                A2 2 0 0 1 22 16.92z"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </span>

                    <span class="k-contact__detail-text">
                        <small>
                            <?php esc_html_e( 'Phone', 'kenda-custom' ); ?>
                        </small>

                        <strong>
                            <?php echo esc_html( $phone ); ?>
                        </strong>
                    </span>
                </a>

            <?php endif; ?>


            <?php if ( $email ) : ?>

                <a
                    class="k-contact__detail"
                    href="mailto:<?php echo esc_attr( $email ); ?>"
                >
                    <span class="k-contact__detail-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <rect
                                x="3"
                                y="5"
                                width="18"
                                height="14"
                                rx="2"
                                stroke="currentColor"
                                stroke-width="1.8"
                            />

                            <path
                                d="m3 7 9 6 9-6"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </span>

                    <span class="k-contact__detail-text">
                        <small>
                            <?php esc_html_e( 'Email', 'kenda-custom' ); ?>
                        </small>

                        <strong>
                            <?php echo esc_html( $email ); ?>
                        </strong>
                    </span>
                </a>

            <?php endif; ?>

        </div>

    </div>


    <!-- Contact Form -->
    <form
        class="k-contact__form"
        id="contact-form"
        method="post"
        enctype="multipart/form-data"
        novalidate
    >

        <?php wp_nonce_field( 'kenda_contact', 'nonce' ); ?>

        <!-- Form Heading -->
        <div class="k-contact__form-heading">

            <div>
                <span class="k-contact__form-eyebrow">
                    <?php esc_html_e( 'Contact Form', 'kenda-custom' ); ?>
                </span>

                <h4>
                    <?php esc_html_e( 'Send a Message', 'kenda-custom' ); ?>
                </h4>
            </div>

            <span class="k-contact__required">
                <span>*</span>
                <?php esc_html_e( 'Required', 'kenda-custom' ); ?>
            </span>

        </div>


        <!-- Honeypot -->
        <div
            class="hp-field"
            aria-hidden="true"
            style="position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden;"
        >
            <label for="contact-company">
                <?php esc_html_e( 'Company', 'kenda-custom' ); ?>
            </label>

            <input
                type="text"
                name="company"
                id="contact-company"
                tabindex="-1"
                autocomplete="off"
            />
        </div>


        <!-- Name / Email -->
        <div class="k-contact__fields">

            <div class="k-contact__field">

                <label for="contact-name">
                    <?php esc_html_e( 'Name', 'kenda-custom' ); ?>
                    <span class="required">*</span>
                </label>

                <input
                    type="text"
                    id="contact-name"
                    name="name"
                    required
                    maxlength="120"
                    autocomplete="name"
                    placeholder="<?php esc_attr_e( 'Your full name', 'kenda-custom' ); ?>"
                />

            </div>


            <div class="k-contact__field">

                <label for="contact-email">
                    <?php esc_html_e( 'Email', 'kenda-custom' ); ?>
                    <span class="required">*</span>
                </label>

                <input
                    type="email"
                    id="contact-email"
                    name="email"
                    required
                    maxlength="190"
                    autocomplete="email"
                    placeholder="<?php esc_attr_e( 'you@example.com', 'kenda-custom' ); ?>"
                />

            </div>

        </div>


        <!-- Source -->
        <div class="k-contact__field">

            <label for="contact-source">
                <?php esc_html_e( 'How did you hear about us?', 'kenda-custom' ); ?>
            </label>

            <input
                type="text"
                id="contact-source"
                name="source"
                maxlength="190"
                autocomplete="off"
                placeholder="<?php esc_attr_e( 'Optional', 'kenda-custom' ); ?>"
            />

        </div>


        <!-- Message -->
        <div class="k-contact__field">

            <label for="contact-message">
                <?php esc_html_e( 'Message', 'kenda-custom' ); ?>
                <span class="required">*</span>
            </label>

            <textarea
                id="contact-message"
                name="message"
                required
                maxlength="5000"
                rows="5"
                placeholder="<?php echo esc_attr( $message_placeholder ); ?>"
            ></textarea>

        </div>


        <!-- Attachment -->
        <div class="k-contact__field">

            <label for="contact-attachment">
                <?php esc_html_e( 'Attachment', 'kenda-custom' ); ?>

                <em>
                    <?php esc_html_e( 'Optional', 'kenda-custom' ); ?>
                </em>
            </label>

            <label
                class="k-contact__upload"
                for="contact-attachment"
            >

                <span class="k-contact__upload-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path
                            d="M12 16V4"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                        />

                        <path
                            d="m7 9 5-5 5 5"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />

                        <path
                            d="M5 20h14"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                        />
                    </svg>
                </span>

                <span class="k-contact__upload-text">

                    <strong>
                        <?php esc_html_e( 'Upload a file', 'kenda-custom' ); ?>
                    </strong>

                    <small>
                        <?php
                        esc_html_e(
                            'PDF, Word, JPG or PNG — max 10 MB',
                            'kenda-custom'
                        );
                        ?>
                    </small>

                </span>

                <span class="k-contact__upload-button">
                    <?php esc_html_e( 'Browse', 'kenda-custom' ); ?>
                </span>

                <input
                    type="file"
                    id="contact-attachment"
                    name="attachment"
                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                />

            </label>

        </div>


        <!-- Submit -->
        <div class="k-contact__footer">

            <p>
                <?php
                esc_html_e(
                    'Required fields are marked with *.',
                    'kenda-custom'
                );
                ?>
            </p>

            <button
                class="k-contact__submit"
                type="submit"
            >
                <?php esc_html_e( 'Send Message', 'kenda-custom' ); ?>

                <span aria-hidden="true">→</span>
            </button>

        </div>


        <!-- Form Status -->
        <p
            class="form-status"
            role="status"
            aria-live="polite"
            hidden
            data-form-status
        ></p>

    </form>

</div>
	
	</div>
</section>
