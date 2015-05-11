<?php
  
function theme_setup() {
    // Menus
    register_nav_menu( 'main', 'Main Menu' );
    // RSS Feed
    add_theme_support( 'automatic-feed-links' );
    // Thumbnails
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'thumb', 150, 150, true ); // Normal thumbnail size
    add_image_size( 'large-thumb', 300, 300, true ); // Large thumbnail size
    }
add_action( 'after_setup_theme', 'theme_setup' );

?>