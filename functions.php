<?php
// Start the engine
include_once( get_template_directory() . '/lib/init.php' );

// Set Localization (do not remove)
load_child_theme_textdomain( 'cc14', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'cc14' ) );

// Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Calvary Chapel HMB 2014', 'cc14' ) );
define( 'CHILD_THEME_URL', 'http://www.cchmb.org/' );

// Add HTML5 markup structure
add_theme_support( 'html5' );

// Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

// Enqueue Google fonts
add_action( 'wp_enqueue_scripts', function() {
  //wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:400,700', array(), null );
});

// Remove all image sizes.
add_filter( 'intermediate_image_sizes_advanced', '__return_empty_array', 99 );

// Add support for custom header
add_theme_support( 'custom-header', array(
  'header-selector' => '.site-title a',
  'header-text'     => false,
  'height'          => 100,
  'width'           => 340,
) );

// Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
  'header',
  'nav',
  'subnav',
  'site-inner',
  'footer-widgets',
  'footer',
) );

// Add support for 4-column footer widgets
add_theme_support( 'genesis-footer-widgets', 4 );

// Return {theme_dir}/css/style.css as the stylesheet_uri.
add_filter( 'stylesheet_uri', function() {
  return get_stylesheet_directory_uri() . '/css/style.css';
});

// Hook after post widget after the entry content
add_action( 'genesis_after_entry', function() {
  if ( is_singular( 'post' ) ) {
    genesis_widget_area( 'after-entry', array(
      'before' => '<div class="after-entry widget-area">',
      'after'  => '</div>',
    ) );
  }
}, 5 );

// Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', function( $size ) {
  return '80';
});

// Remove edit link
add_filter( 'genesis_edit_post_link', '__return_false' );

// Remove comment form allowed tags
add_filter( 'comment_form_defaults', function( $defaults ) {
  $defaults['comment_notes_after'] = '';
  return $defaults;
});

// Add the sub footer section
add_action( 'genesis_before_footer', function() {
  if ( is_active_sidebar( 'sub-footer-left' ) || is_active_sidebar( 'sub-footer-right' ) ) {
    echo '<div class="sub-footer"><div class="wrap">';

    genesis_widget_area( 'sub-footer-left', array(
      'before' => '<div class="sub-footer-left">',
      'after'  => '</div>',
    ) );

    genesis_widget_area( 'sub-footer-right', array(
      'before' => '<div class="sub-footer-right">',
      'after'  => '</div>',
    ) );

    echo '</div><!-- end .wrap --></div><!-- end .sub-footer -->';
  }
}, 5 );

// Cleanup hooks
add_action( 'init', function () {
  remove_action ('wp_head', 'mbsb_enqueue_frontend_scripts_and_styles');
}, 99 );

add_filter( 'wp_head', function() { ?>
<script>
  // Chrome occasionally has issues applying this properly in CSS
  (function() { document.documentElement.style.fontSize = "62.5%"; })();
</script>
<?php });

// Register widget areas
genesis_register_sidebar( array(
  'id'          => 'home-top',
  'name'        => __( 'Home - Top', 'cc14' ),
  'description' => __( 'This is the top section of the Home page.', 'cc14' ),
) );
genesis_register_sidebar( array(
  'id'          => 'home-bottom',
  'name'        => __( 'Home - Bottom', 'cc14' ),
  'description' => __( 'This is the bottom section of the Home page.', 'cc14' ),
) );
genesis_register_sidebar( array(
  'id'          => 'after-entry',
  'name'        => __( 'After Entry', 'cc14' ),
  'description' => __( 'This is the after entry widget area.', 'cc14' ),
) );
genesis_register_sidebar( array(
  'id'          => 'sub-footer-left',
  'name'        => __( 'Sub Footer - Left', 'cc14' ),
  'description' => __( 'This is the left section of the sub footer.', 'cc14' ),
) );
genesis_register_sidebar( array(
  'id'          => 'sub-footer-right',
  'name'        => __( 'Sub Footer - Right', 'cc14' ),
  'description' => __( 'This is the right section of the sub footer.', 'cc14' ),
) );
genesis_register_sidebar( array(
  'id'          => 'sermon-sidebar',
  'name'        => __( 'Sermon - Primary Sidebar', 'cc14' ),
  'description' => __( 'This is the primary sidebar of Sermon pages.', 'cc14' ),
) );
genesis_register_sidebar( array(
  'id'          => 'about-bottom',
  'name'        => __( 'About - Bottom', 'cc14' ),
  'description' => __( 'This is the bottom section of the About page.', 'cc14' ),
) );
genesis_register_sidebar( array(
  'id'          => 'preacher-sidebar',
  'name'        => __( 'Preacher - Primary Sidebar', 'cc14' ),
  'description' => __( 'This is the primary sidebar of Preacher pages.', 'cc14' ),
) );
genesis_register_sidebar( array(
  'id'          => 'series-sidebar',
  'name'        => __( 'Sermon Series - Primary Sidebar', 'cc14' ),
  'description' => __( 'This is the primary sidebar of Sermon Series pages.', 'cc14' ),
) );
