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

		<div class="contact-shell">
			<aside class="contact-shell__aside">
				<h3 class="contact-shell__aside-title"><?php esc_html_e( 'Campaign Office', 'kenda-custom' ); ?></h3>
				<ul class="contact-info-list">
					<?php if ( $phone ) : ?>
						<li class="contact-info-list__item">
							<span class="contact-info-list__label"><?php esc_html_e( 'Phone', 'kenda-custom' ); ?></span>
							<a href="tel:<?php echo esc_attr( $tel ); ?>"><?php echo esc_html( $phone ); ?></a>
						</li>
					<?php endif; ?>
					<?php if ( $email ) : ?>
						<li class="contact-info-list__item">
							<span class="contact-info-list__label"><?php esc_html_e( 'Email', 'kenda-custom' ); ?></span>
							<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
						</li>
					<?php endif; ?>
				</ul>
				<p class="contact-shell__note"><?php esc_html_e( 'Required fields are marked with *', 'kenda-custom' ); ?></p>
			</aside>

			<form class="contact-shell__form contact-form" id="contact-form" novalidate enctype="multipart/form-data">
				<h3 class="contact-form__title"><?php esc_html_e( 'Send a message', 'kenda-custom' ); ?></h3>

				<div class="hp-field" aria-hidden="true">
					<label for="company"><?php esc_html_e( 'Company', 'kenda-custom' ); ?></label>
					<input type="text" name="company" id="company" tabindex="-1" autocomplete="off" />
				</div>

				<div class="contact-form__grid">
					<div class="form-field">
						<label class="form-label" for="contact-name"><?php esc_html_e( 'Name', 'kenda-custom' ); ?> <span class="form-required" aria-hidden="true">*</span></label>
						<input class="form-control" type="text" id="contact-name" name="name" required maxlength="120" autocomplete="name" />
					</div>
					<div class="form-field">
						<label class="form-label" for="contact-email"><?php esc_html_e( 'Email', 'kenda-custom' ); ?> <span class="form-required" aria-hidden="true">*</span></label>
						<input class="form-control" type="email" id="contact-email" name="email" required maxlength="190" autocomplete="email" />
					</div>
				</div>

				<div class="form-field">
					<label class="form-label" for="contact-source"><?php esc_html_e( 'Where did you hear about us?', 'kenda-custom' ); ?></label>
					<input class="form-control" type="text" id="contact-source" name="source" maxlength="190" autocomplete="off" />
				</div>

				<div class="form-field">
					<label class="form-label" for="contact-message"><?php esc_html_e( 'Message', 'kenda-custom' ); ?> <span class="form-required" aria-hidden="true">*</span></label>
					<textarea
						class="form-control form-control--textarea"
						id="contact-message"
						name="message"
						required
						maxlength="5000"
						rows="4"
						placeholder="<?php echo esc_attr( $message_placeholder ); ?>"
					></textarea>
				</div>

				<div class="form-field form-field--file">
					<label class="form-label" for="contact-attachment"><?php esc_html_e( 'Attachment (optional)', 'kenda-custom' ); ?></label>
					<input class="form-control form-control--file" type="file" id="contact-attachment" name="attachment" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" />
					<p class="form-hint"><?php esc_html_e( 'PDF, Word, JPG, or PNG — max 10 MB.', 'kenda-custom' ); ?></p>
				</div>

				<button class="btn btn--navy contact-form__submit" type="submit"><?php esc_html_e( 'Send Message', 'kenda-custom' ); ?></button>
				<p class="form-status" role="status" aria-live="polite" hidden data-form-status></p>
			</form>
		</div>
	</div>
</section>
