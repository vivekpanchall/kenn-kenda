<?php
/**
 * Site footer.
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);

$phone = kenda_site( 'contact_phone' );
$email = kenda_site( 'contact_email' );
$tel   = preg_replace( '/\D+/', '', (string) $phone );
$newsletter_placeholder = __( 'you@example.com', 'kenda-custom' );
?>
</main>
<footer class="site-footer">
	<div class="site-footer__inner">
		<div class="site-footer__grid">
			<div class="site-footer__brand">
				<p class="display-sm"><?php echo esc_html( kenda_site( 'site_name', get_bloginfo( 'name' ) ) ); ?></p>
				<p><?php esc_html_e( 'Leadership for ALL of Kansas City.', 'kenda-custom' ); ?></p>
				<ul class="contact-list">
					<?php if ( $phone ) : ?>
						<li><a href="tel:<?php echo esc_attr( $tel ); ?>"><?php echo esc_html( $phone ); ?></a></li>
					<?php endif; ?>
					<?php if ( $email ) : ?>
						<li><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
					<?php endif; ?>
				</ul>
			</div>
			<nav class="site-footer__nav" aria-label="<?php esc_attr_e( 'Footer', 'kenda-custom' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'menu_class'     => 'site-footer__links',
						'fallback_cb'    => 'kenda_fallback_nav',
					)
				);
				?>
			</nav>
			<div class="site-footer__newsletter" id="newsletter">
				<p class="eyebrow eyebrow--gold"><?php echo esc_html( kenda_site( 'newsletter_heading', __( 'Join the Campaign!', 'kenda-custom' ) ) ); ?></p>
				<p><?php echo esc_html( kenda_site( 'newsletter_description', __( 'Stay informed — join the campaign community.', 'kenda-custom' ) ) ); ?></p>
				<form class="newsletter-form" id="newsletter-form" novalidate>
					<div class="newsletter-form__field">
						<label class="form-label form-label--light" for="newsletter-email"><?php esc_html_e( 'Email address', 'kenda-custom' ); ?></label>
						<div class="newsletter-form__row">
							<input class="form-control form-control--footer" type="email" id="newsletter-email" name="email" required autocomplete="email" placeholder="<?php echo esc_attr( $newsletter_placeholder ); ?>" />
							<button type="submit" class="btn btn--gold btn--sm"><?php esc_html_e( 'Join', 'kenda-custom' ); ?></button>
						</div>
					</div>
					<input type="text" name="company" class="hp-field" tabindex="-1" autocomplete="off" aria-hidden="true" />
					<p class="form-status form-status--light" role="status" aria-live="polite" hidden data-newsletter-status></p>
				</form>
			</div>
		</div>
		<div class="site-footer__social">
			<?php
			$social = array(
				'facebook_url'  => __( 'Facebook', 'kenda-custom' ),
				'instagram_url' => __( 'Instagram', 'kenda-custom' ),
				'twitter_url'   => __( 'X', 'kenda-custom' ),
			);
			foreach ( $social as $key => $label ) {
				$url = kenda_site( $key );
				if ( $url ) {
					printf( '<a href="%s" target="_blank" rel="noopener noreferrer">%s</a>', esc_url( $url ), esc_html( $label ) );
				}
			}
			?>
		</div>
		<div class="site-footer__legal">
			<p><?php echo esc_html( kenda_site( 'copyright_text', '© ' . gmdate( 'Y' ) . ' Kenda Tomes McClain 4 KC' ) ); ?></p>
			<?php if ( kenda_site( 'footer_disclaimer' ) ) : ?>
				<p class="site-footer__disclaimer"><?php echo esc_html( kenda_site( 'footer_disclaimer' ) ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
