<?php /* Category */
get_header(); ?>
<section class="category">
  <div class="container">
    <div class="twelve columns">
      <h1><?php single_cat_title(); ?></h1>
        <?php if ( have_posts() ) : while (have_posts()) : the_post(); ?>
          <article class="item one-third column">
            <?php the_title(); ?> 
          </article>
          <?php endwhile; else : ?>
          <!-- No posts found -->
        <?php endif; wp_reset_query(); ?>
    </div>
  </div>
</section>
<?php get_footer(); ?>