<?php /* Tags */ get_header(); ?>

<div class="container">
  <div class="sixteen columns">
		<?php if ( have_posts() ) : ?>
		  <h1><?php printf( __( 'Tag Archives: %s', 'twentytwelve' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h1>
				<div class="archive-meta"><?php echo tag_description(); ?></div>
			<?php endif; ?>
			<?php while ( have_posts() ) : the_post(); ?>
			<!-- Template here -->
			<?php endwhile; ?>			
		<?php else : endif; ?>
  </div>
</div>

<?php get_footer(); ?>