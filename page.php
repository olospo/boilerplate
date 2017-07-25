<?php /*  Single Post */
get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<section class="page">
  <div class="container">
    <div class="twelve columns">
      <h1><?php the_title(); ?></h1>
      <?php the_content(); ?>
    </div>
  </div>
</section>
<?php endwhile; // end of the loop. ?>
<?php get_footer(); ?>