<?php
function theme_setup() {
  // Menus
  register_nav_menu( 'main', 'Main Menu' );
  register_nav_menu( 'footer', 'Footer Menu' );
  // RSS Feed
  add_theme_support( 'automatic-feed-links' );
  // Thumbnails
  add_theme_support( 'post-thumbnails' );
  add_image_size( 'thumb', 150, 150, true ); // Normal thumbnail size
  add_image_size( 'large-thumb', 300, 300, true ); // Large thumbnail size 
  add_image_size( 'featured-img', 740, 420, true ); // Featured Image size 
}
add_action( 'after_setup_theme', 'theme_setup' );

// Enqueue styles
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
  wp_enqueue_style( 'main', get_stylesheet_directory_uri().'/css/main.css', false, '1.0' );
  wp_enqueue_style( 'fonts', 'https://fonts.googleapis.com/css?family=Montserrat:400,700|Noto+Serif:400,700|Sanchez', false, '1.0');
}

// Enqueue scripts
add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );
function theme_enqueue_scripts() {
  wp_deregister_script( 'jquery' ); // Deregister to put jQuery into footer
  wp_register_script( 'jquery', get_stylesheet_directory_uri().'/js/jquery.min.js', false, NULL, true );
  wp_enqueue_script( 'jquery' ); // Re-register jQuery
  wp_enqueue_script( 'modernizr', get_stylesheet_directory_uri().'/js/modernizr.js', 'jquery', NULL, true );
  wp_enqueue_script( 'retina', get_stylesheet_directory_uri().'/js/retina.js', 'jquery', NULL , true );
  wp_enqueue_script( 'theme-functions', get_stylesheet_directory_uri().'/js/functions.js', 'jquery', NULL , true );
}

// Options Page
if( function_exists('acf_add_options_page') ) {
  acf_add_options_page(array(
    'page_title' 	=> 'Theme General Settings',
    'menu_title'	=> 'Theme Settings',
    'menu_slug' 	=> 'theme-general-settings',
    'capability'	=> 'edit_posts',
    'redirect'		=> true
  ));
  acf_add_options_sub_page(array(
    'page_title' 	=> 'Theme General Settings',
    'menu_title'	=> 'General',
    'parent_slug'	=> 'theme-general-settings',
  ));
  acf_add_options_sub_page(array(
    'page_title' 	=> 'Theme Footer Settings',
    'menu_title'	=> 'Footer',
    'parent_slug'	=> 'theme-general-settings',
  ));
}

// Excerpt Length
function excerpt_length($length) {
  return 80;
}
add_filter('excerpt_length', 'excerpt_length');

// Read More after excerpt
function new_excerpt_more($more) {
  global $post;
  return '';
}
add_filter('excerpt_more', 'new_excerpt_more');

// Is Tree
function is_tree($page_id) { // $pid = The ID of the page we’re looking for pages underneath
  global $post; 
  $anc = get_post_ancestors( $post->ID );
foreach($anc as $ancestor) {
  if(is_page() && $ancestor == $page_id) {
    return true;
  }
}
if(is_page()&&(is_page($page_id)))
  return true; 
  else return false; 
};

// Pagination
function numeric_posts_nav() {
  if( is_singular() )
    return;
  global $wp_query;
  // Stop execution if there's only one page
  if( $wp_query->max_num_pages <= 1 )
    return;
  $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
  $max   = intval( $wp_query->max_num_pages );
  //	Add current page to the array
  if ( $paged >= 1 )
    $links[] = $paged;
  //	Add the pages around the current page to the array
  if ( $paged >= 3 ) {
    $links[] = $paged - 1;
    $links[] = $paged - 2;
  }
  if ( ( $paged + 2 ) <= $max ) {
    $links[] = $paged + 2;
    $links[] = $paged + 1;
  }
  echo '<div class="pagination"><ul>' . "\n";
  //	Previous Post Link
  if ( get_previous_posts_link() )
    printf( '<li class="prev">%s</li>' . "\n", get_previous_posts_link('Previous Page') );
  // Link to first page, plus ellipses if necessary
  if ( ! in_array( 1, $links ) ) {
    $class = 1 == $paged ? ' class="active"' : '';
    printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
    if ( ! in_array( 2, $links ) )
      echo '<li>…</li>';
  }
  //	Link to current page, plus 2 pages in either direction if necessary
  sort( $links );
  foreach ( (array) $links as $link ) {
    $class = $paged == $link ? ' class="active"' : '';
    printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
  }
  //	Link to last page, plus ellipses if necessary
  if ( ! in_array( $max, $links ) ) {
    if ( ! in_array( $max - 1, $links ) )
      echo '<li>…</li>' . "\n";
    $class = $paged == $max ? ' class="active"' : '';
    printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
  }
  //	Next Post Link
  if ( get_next_posts_link() )
    printf( '<li class="next">%s</li>' . "\n", get_next_posts_link('Next Page') );
  echo '</ul></div>' . "\n";
}
// This stuff fixes the pagination issue with custom posts. 
function remove_page_from_query_string($query_string) { 
  if ($query_string['name'] == 'page' && isset($query_string['page'])) {
    unset($query_string['name']);
    // 'page' in the query_string looks like '/2', so i'm spliting it out
    list($delim, $page_index) = split('/', $query_string['page']);
    $query_string['paged'] = $page_index;
  }      
  return $query_string;
}

add_filter('request', 'remove_page_from_query_string');
function fix_category_pagination($qs){
  if(isset($qs['category_name']) && isset($qs['paged'])){
    $qs['post_type'] = get_post_types($args = array(
      'public'   => true,
      '_builtin' => false
    ));
    array_push($qs['post_type'],'post');
  }
  return $qs;
}
add_filter('request', 'fix_category_pagination');

// Get ID from Page Name
function ID_from_page_name($page_name)
{
  global $wpdb;
  $page_name_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '".$page_name."'");
  return $page_name_id;
}

// Breadcrumbs
function breadcrumbs() {
 
  /* === OPTIONS === */
  $text['home']     = 'Home'; // text for the 'Home' link
  $text['category'] = '%s'; // text for a category page
  $text['search']   = 'Search Results for "%s"'; // text for a search results page
  $text['tag']      = 'Posts Tagged "%s"'; // text for a tag page
  $text['author']   = 'Articles Posted by %s'; // text for an author page
  $text['404']      = 'Error 404'; // text for the 404 page
 
  $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
  $showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
  $delimiter   = ' > '; // delimiter between crumbs
  $before      = '<span class="current">'; // tag before the current crumb
  $after       = '</span>'; // tag after the current crumb
  /* === END OF OPTIONS === */
 
  global $post;
  $homeLink = get_bloginfo('url') . '/';
  $linkBefore = '<span typeof="v:Breadcrumb">';
  $linkAfter = '</span>';
  $linkAttr = ' rel="v:url" property="v:title"';
  $link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

  if (is_home() || is_front_page()) {
    if ($showOnHome == 1) echo '<a href="' . $homeLink . '">' . $text['home'] . '</a>';
  } else {
    echo '<div id="crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">' . sprintf($link, $homeLink, $text['home']) . $delimiter;
    if ( is_category() ) {
      $thisCat = get_category(get_query_var('cat'), false);
      if ($thisCat->parent != 0) {
        $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
        $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
        $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
        echo $cats;
      }
      echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;
    } elseif ( is_search() ) {
      echo $before . sprintf($text['search'], get_search_query()) . $after;
    } elseif ( is_day() ) {
    //echo sprintf($link, '/category/news' , 'News') . $delimiter;	
      echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
      echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
      echo $before . get_the_time('d') . $after;
    } elseif ( is_month() ) {
    //echo sprintf($link, '/category/news' , 'News') . $delimiter;	
      echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
      echo $before . get_the_time('F') . $after;
    } elseif ( is_year() ) {
    // echo sprintf($link, '/category/news' , 'News') . $delimiter;	
      echo $before . get_the_time('Y') . $after;
    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
    if ($post_type->name == 'eq_guidelines') {
      echo sprintf($link, '/library' , 'Library') . $delimiter;
    }
        $slug = $post_type->rewrite;
        printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
        if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        $cats = get_category_parents($cat, TRUE, $delimiter);
        if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
        $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
        $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
        echo $cats;
        if ($showCurrent == 1) echo $before . get_the_title() . $after;
      }
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      
    // For the Reporting Guideline search the post type is passed in via GET
    $the_post_type = isset($_GET['post_type']) ? $_GET['post_type'] : get_post_type();   
    $post_type = get_post_type_object($the_post_type);		
    if (!empty( $post_type )) {
    if ($post_type->name == 'eq_guidelines') {
      echo sprintf($link, '/library' , 'Library') . $delimiter;
    }
      echo $before . $post_type->labels->singular_name . $after;
    }
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      $cats = get_category_parents($cat, TRUE, $delimiter);
      $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
      $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
      echo $cats;
      printf($link, get_permalink($parent), $parent->post_title);
      if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
    } elseif ( is_page() && !$post->post_parent ) {
      if ($showCurrent == 1) echo $before . get_the_title() . $after; 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      for ($i = 0; $i < count($breadcrumbs); $i++) {
        echo $breadcrumbs[$i];
        if ($i != count($breadcrumbs)-1) echo $delimiter;
      }
      if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
    } elseif ( is_tag() ) {
      echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $before . sprintf($text['author'], $userdata->display_name) . $after;
    } elseif ( is_404() ) {
      echo $before . $text['404'] . $after;
    }
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
    echo '</div>';
  }
}

// Allow SVG Uploads

function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

?>