<?php
/**
 * Site header.
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);

$cta            = kenda_header_cta();
$portrait_id    = kenda_header_portrait_id();
$logo_alt       = kenda_site( 'site_name', get_bloginfo( 'name' ) );
$portrait_fallback = KENDA_THEME_URI . '/assets/images/kenda-portrait.png';
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main-content"><?php esc_html_e( 'Skip to content', 'kenda-custom' ); ?></a>
<header class="site-header" data-header>
	<div class="site-header__inner">
		<div class="site-brand site-brand--portrait">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-brand__logo-link" aria-label="<?php echo esc_attr( (string) $logo_alt ); ?>">
				<?php
				echo kenda_render_image(
					$portrait_id,
					'medium',
					array(
						'class' => 'site-brand__logo-img site-brand__logo-img--portrait',
						'alt'   => (string) $logo_alt,
					),
					$portrait_fallback,
					(string) $logo_alt
				);
				?>
			</a>
		</div>
		<button type="button" class="site-nav-toggle" data-nav-toggle aria-expanded="false" aria-controls="primary-navigation">
			<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'kenda-custom' ); ?></span>
			<span aria-hidden="true"></span>
			<span aria-hidden="true"></span>
			<span aria-hidden="true"></span>
		</button>
		<nav id="primary-navigation" class="site-nav" data-nav aria-label="<?php esc_attr_e( 'Primary', 'kenda-custom' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'site-nav__list',
					'fallback_cb'    => 'kenda_fallback_nav',
				)
			);
			?>
			<?php if ( ! empty( $cta['text'] ) && ! empty( $cta['url'] ) ) : ?>
				<a class="btn btn--gold btn--sm site-header__cta" href="<?php echo esc_url( $cta['url'] ); ?>"><?php echo esc_html( $cta['text'] ); ?></a>
			<?php endif; ?>
		</nav>
	</div>
</header>
<main id="main-content">
