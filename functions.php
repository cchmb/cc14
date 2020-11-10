<?php
// Start the engine
include_once( get_template_directory() . '/lib/init.php' );
include_once( __DIR__ . '/framework/framework.php' );
include_once( __DIR__ . '/widgets.php' );

// Set Localization (do not remove)
load_child_theme_textdomain( 'cc14', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'cc14' ) );

// Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Calvary Chapel HMB 2014', 'cc14' ) );
define( 'CHILD_THEME_URL', 'https://www.cchmb.org/' );


// Add HTML5 markup structure
add_theme_support( 'html5' );

// Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

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

add_theme_support( 'ctfw-sermon-date-archive' );
add_theme_support( 'church-theme-content' );

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
  'field_overrides' => array(),
) );

// Remove all image resizes.
add_filter( 'intermediate_image_sizes_advanced', '__return_empty_array', 99 );

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

// Add content-specific default images
add_filter( 'genesis_get_image_default_args', function ( $defaults, $args ) {
  if ( is_tax() ) {
    if ($id = apply_filters('taxonomy-images-queried-term-image-id', 0)) {
      $defaults['fallback'] = $id;
    }
  } else {
    $type = get_post_type( $args['post_id'] );
    switch ($type) {
      case 'ctc_sermon':
        if ($series = apply_filters('taxonomy-images-get-the-terms', '',
                                    ['post_id'=>$post->ID, 'taxonomy'=>'ctc_sermon_series'])) {
          $defaults['fallback'] = $series[0]->image_id;
        }
    }
  }

  return $defaults;
}, 10, 2);

// display speaker as the author for sermons
add_action( "wp", function() {
  if ( ctfw_current_content_type() == 'sermon' ) {
    if ($speakers = get_the_terms( $post->ID, 'ctc_sermon_speaker' )) {
      $speaker = $speakers[0];
      add_filter( "the_author", function( $author ) use ( $speaker ) {
        return $speaker->name;
      });
      add_filter( "author_link", function( $link ) use ( $speaker ) {
        return get_term_link($speaker);
      });
    }
  }
});
