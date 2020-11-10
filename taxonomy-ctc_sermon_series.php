<?php

// Add series sidebar widgets if present
if ( is_active_sidebar( 'sermon-series-sidebar' ) ) {
  add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

  // Display series sidebar instead of primary
  remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
  add_action( 'genesis_sidebar', function() {
    genesis_widget_area( 'sermon-series-sidebar', array() );
  });
}

// Remove genesis loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

// replace default genesis archive headline with custom
remove_action( 'genesis_archive_title_descriptions', 'genesis_do_archive_headings_headline', 10, 3 );
add_action( 'genesis_archive_title_descriptions', function($heading='', $intro_text='', $context='') {
  if ($image = genesis_get_image()) {
    $heading = $image;
  } else {
    if ( !$heading ) {
      $term = get_queried_object();
      $heading = $term->name;
    }
    $heading = esc_html( wp_strip_all_tags( $heading ) );
  }

  if ( $context && $heading ) {
    printf( '<h1 %s>%s</h1>', genesis_attr( 'archive-title' ), $heading );
  }
}, 10, 3 );



// use series description if no intro text is present
add_filter('genesis_term_intro_text_output', function( $text ) {
  if ( !$text ) {
     $term = get_queried_object();
     $text = '<p>' . $term->description . '</p>';
  }
  return $text;
}, 10);



// Use featured image in place of title if present.

add_action( 'genesis_post_title_text', function( $text ) {
  $img = genesis_get_image('size=large');
  if ( $img ) {
    $text = $img;
  }
  return $text;
});

genesis();
