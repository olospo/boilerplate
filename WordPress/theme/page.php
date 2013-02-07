<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 *
 * @package WordPress
 * @subpackage olospo
 *
 */

get_header(); ?>

<div class="container">
	<div class="two-thirds column">
		<?php while ( have_posts() ) : the_post(); ?>
		<h1><?php the_title(); ?></h1>
		<?php the_content();?>
		<?php endwhile; // end of the loop. ?>
	</div>
	<div class="one-third column">
		<?php get_sidebar(); ?>
	</div>
</div>

<?php get_footer(); ?>