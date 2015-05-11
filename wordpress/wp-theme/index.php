<?php /* The main template file. */ get_header(); ?>

<div class="container">
  <div class="sixteen columns">
    <?php while ( have_posts() ) : the_post(); ?>
      <h1><?php the_title(); ?></h1>
      <?php the_content(); ?>
    <?php endwhile; // end of the loop. ?>
  </div>
</div>

<?php get_footer(); ?>