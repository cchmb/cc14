<?php
// Start the engine
include_once( get_template_directory() . '/lib/init.php' );
include_once( __DIR__ . '/framework/framework.php' );
include_once( __DIR__ . '/widgets.php' );

// Set Localization (do not remove)
load_child_theme_textdomain( 'cc14', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'cc14' ) );

// Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Calvary Chapel HMB 2014', 'cc14' ) );
define( 'CHILD_THEME_URL', 'http://www.cchmb.org/' );

// Add HTML5 markup structure
add_theme_support( 'html5' );

// Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

add_theme_support( 'ctfw-sermon-date-archive' );



add_theme_support( 'church-theme-content' );

  /**
    * Plugin Features
    *
    * When array of arguments not given, plugin defaults are used (enabling all taxonomies
    * and fields for feature). It is recommended to explicitly specify taxonomies and
    * fields used by theme so plugin updates don't reveal unsupported features.
    */

// Sermons
add_theme_support( 'ctc-sermons', array(
  'taxonomies' => array(
    'ctc_sermon_topic',
    'ctc_sermon_book',
    'ctc_sermon_series',
    'ctc_sermon_speaker',
    'ctc_sermon_tag',
  ),
  'fields' => array(
    '_ctc_sermon_has_full_text',
    '_ctc_sermon_video',
    '_ctc_sermon_audio',
    '_ctc_sermon_pdf',
  ),
  'field_overrides' => array()
) );

// Events
add_theme_support( 'ctc-events', array(
  'taxonomies' => array(
    'ctc_event_category',
  ),
  'fields' => array(
    '_ctc_event_start_date',
    '_ctc_event_end_date',
    '_ctc_event_time',
    '_ctc_event_recurrence',
    '_ctc_event_recurrence_end_date',
    '_ctc_event_venue',
    '_ctc_event_address',
    '_ctc_event_show_directions_link',
    '_ctc_event_map_lat',
    '_ctc_event_map_lng',
    '_ctc_event_map_type',
    '_ctc_event_map_zoom',
  ),
  'field_overrides' => array(
    '_ctc_event_map_type' => array(
      'default' => 'HYBRID',
    ),
    '_ctc_event_map_zoom' => array(
      'default' => '14',
    ),
  )
) );

// People
add_theme_support( 'ctc-people', array(
  'taxonomies' => array(
    'ctc_person_group',
  ),
  'fields' => array(
    '_ctc_person_position',
    '_ctc_person_phone',
    '_ctc_person_email',
    '_ctc_person_urls',
  ),
  'field_overrides' => array(                                                                                                                                                                             '_ctc_person_email' => array(
      'desc' => sprintf( __( 'The WordPress <a href="%s" target="_blank">antispambot</a> function is used to help deter automated email harvesting.', 'onechurch' ), 'http://codex.wordpress.org/Function_Reference/antispambot' ),
    ),
  ),
) );

// Locations
add_theme_support( 'ctc-locations', array(
  'taxonomies' => array(),
  'fields' => array(
    '_ctc_location_address',
    '_ctc_location_show_directions_link',
    '_ctc_location_map_lat',
    '_ctc_location_map_lng',
    '_ctc_location_map_type',
    '_ctc_location_map_zoom',
    '_ctc_location_phone',
    '_ctc_location_times',
  ),
  'field_overrides' => array(
    '_ctc_location_map_type' => array(
      'default' => 'HYBRID',
    ),
    '_ctc_location_map_zoom' => array(
      'default' => '14',
    ),
  )
) );




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
  remove_filter ('the_title', 'mbsb_filter_titles', 10, 2);
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
  'id'          => 'sermon-speaker-sidebar',
  'name'        => __( 'Speaker - Primary Sidebar', 'cc14' ),
  'description' => __( 'This is the primary sidebar of Speaker pages.', 'cc14' ),
) );
genesis_register_sidebar( array(
  'id'          => 'sermon-series-sidebar',
  'name'        => __( 'Sermon Series - Primary Sidebar', 'cc14' ),
  'description' => __( 'This is the primary sidebar of Sermon Series pages.', 'cc14' ),
) );

/*
add_filter( "the_author", function( $author ) {
  return "foo";
});
*/
