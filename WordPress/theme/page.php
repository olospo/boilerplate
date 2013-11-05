<?php /* Pages */ get_header(); ?>

<div class="container">
	<div class="sixtenn columns">
		<?php while ( have_posts() ) : the_post(); ?>
		<h1><?php the_title(); ?></h1>
		<?php the_content();?>
		<?php endwhile; // end of the loop. ?>
	</div>
</div>

<?php get_footer(); ?>