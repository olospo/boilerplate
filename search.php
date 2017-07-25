<?php /*  Single Post */
get_header(); ?>
<section class="search">
  <div class="container">
    <div class="twelve columns">
      <h1><?php printf( __( 'Search Results for: %s', 'twentytwelve' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
      <?php if ( have_posts() ) : // Show search results ?>
  		  <?php while ( have_posts() ) : the_post(); ?>
  		    <article class="search_item">
  		      <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
  		    </article>
        <?php endwhile; ?>
  			  <?php numeric_posts_nav(); ?>
        <?php else : // No search results found ?>
    		<article class="search_item">
    		  <h2>No Results Found</h1>
    		  <p>Sorry, but nothing matched your search criteria. Please try again with some different keywords and/or search criteria.</p>
    		</article>
  		<?php endif; ?>
    </div>
  </div>
</section>
<?php get_footer(); ?>