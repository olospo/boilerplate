<?php /* Category */ get_header(); ?>

<div class="container">
  <div class="two-thirds column">
    <?php if ( have_posts() ) : ?>
      <h1><?php single_cat_title(); ?></h1>
      <?php while ( have_posts() ) : the_post(); ?>
        <?php /* Content here */	?>	
      <?php endwhile; else : ?>
        <?php /* No content to display */	?>
    <?php endif; ?>
  </div>
  <div class="one-third column">
    <?php get_sidebar(); ?>
  </div>
</div>

<?php get_footer(); ?>