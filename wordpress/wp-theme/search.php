<?php /* Search */ get_header(); ?>

<div class="container">
  <div class="sixteen columns">
		<?php if ( have_posts() ) : // Show search results ?>
		<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentytwelve' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
		  <?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>
		<?php else : // No search results found ?>
		<h1>No Results Found</h1>
		  <p>Sorry, but nothing matched your search criteria. Please try again with some different keywords.</p>
		<?php endif; ?>
		</div>
</div>

<?php get_footer(); ?>