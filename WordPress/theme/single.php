<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

<div class="container">
	<div class="two-thirds column">
			<?php while ( have_posts() ) : the_post(); ?>
				<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
				<h5><?php the_date(); ?></h5>
				<?php the_content(); ?>			
			<?php endwhile; // end of the loop. ?>
	</div>
	<div class="one-third column">
		<?php get_sidebar(); ?>
	</div>
</div>

<?php get_footer(); ?>