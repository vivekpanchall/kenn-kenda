<?php
/**
 * Front page template — single-page layout.
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);

get_header();
?>
<?php get_template_part( 'template-parts/hero' ); ?>
<?php get_template_part( 'template-parts/home-content' ); ?>
<?php get_template_part( 'template-parts/contact' ); ?>
<?php
get_footer();
