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

$footer_title = __( 'Kenda Tomes McClain for Mayor of Kansas City', 'kenda-custom' );

$disclaimer = kenda_site(
	'footer_disclaimer',
	__( 'Paid for by [Committee Name], [Treasurer Name], Treasurer.', 'kenda-custom' )
);

$social_links = array();
$social_map   = array(
	'facebook_url'  => __( 'Facebook', 'kenda-custom' ),
	'instagram_url' => __( 'Instagram', 'kenda-custom' ),
	'linkedin_url'   => __( 'LinkedIn', 'kenda-custom' ),
	'tiktok_url'    => __( 'TikTok', 'kenda-custom' ),
	'youtube_url'   => __( 'YouTube', 'kenda-custom' ),
	'x_url'   => __( 'X', 'kenda-custom' ),
);
foreach ( $social_map as $key => $label ) {
	$url = kenda_site( $key );
	if ( $url ) {
		$social_links[] = array(
			'url'   => $url,
			'label' => $label,
		);
	}
}
?>
</main>
<footer class="site-footer">
	<div class="site-footer__inner">
		<p class="site-footer__title"><?php echo esc_html( (string) $footer_title ); ?></p>

		<?php if ( $phone || $email ) : ?>
			<p class="site-footer__contact">
				<?php if ( $phone ) : ?>
					<a href="tel:<?php echo esc_attr( (string) $tel ); ?>"><?php echo esc_html( (string) $phone ); ?></a>
				<?php endif; ?>
				<?php if ( $phone && $email ) : ?>
					<span class="site-footer__sep" aria-hidden="true">|</span>
				<?php endif; ?>
				<?php if ( $email ) : ?>
					<a href="mailto:<?php echo esc_attr( (string) $email ); ?>"><?php echo esc_html( (string) $email ); ?></a>
				<?php endif; ?>
			</p>
		<?php endif; ?>

		<?php if ( $social_links ) : ?>
			<p class="site-footer__social">
				<?php foreach ( $social_links as $index => $item ) : ?>
					<?php if ( $index > 0 ) : ?>
						<span class="site-footer__sep" aria-hidden="true">|</span>
					<?php endif; ?>
					<a href="<?php echo esc_url( $item['url'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $item['label'] ); ?></a>
				<?php endforeach; ?>
			</p>
		<?php endif; ?>

		<?php if ( $disclaimer ) : ?>
			<p class="site-footer__disclaimer"><?php echo esc_html( (string) $disclaimer ); ?></p>
		<?php endif; ?>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
