<?php
/**
 * Fallback index template.
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);

get_header();
?>
<section class="section section--page">
	<div class="section__inner">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : ?>
				<?php the_post(); ?>
				<article <?php post_class(); ?>>
					<h1 class="display-md"><?php the_title(); ?></h1>
					<div class="entry-content"><?php the_content(); ?></div>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<p><?php esc_html_e( 'No content found.', 'kenda-custom' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
