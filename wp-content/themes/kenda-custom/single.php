<?php
/**
 * Single post template.
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);

get_header();
?>
<section class="section section--page">
	<div class="section__inner">
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<article <?php post_class(); ?>>
				<h1 class="display-md"><?php the_title(); ?></h1>
				<div class="entry-content"><?php the_content(); ?></div>
			</article>
		<?php endwhile; ?>
	</div>
</section>
<?php
get_footer();
