<?php /* Header */  ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<title><?php bloginfo('name'); ?><?php wp_title( '|', true, 'left' ); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=3.0, minimal-ui" />
<?php wp_head(); ?>
<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/img/favicon.ico">
</head>
<body <?php body_class(); ?>>
<header>
  <div class="container">
    <div class="twelve columns">
      <h1><a href="<?php echo get_site_url(); ?>"><?php bloginfo('name'); ?></a></h1>
    </div>
  </div>
</header>
<nav>
  <?php wp_nav_menu( array( 'theme_location' => 'main' ) ); ?>
</nav>