<?php

// Add series sidebar widgets if present
if ( is_active_sidebar( 'series-sidebar' ) ) {
  add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

  // Display series sidebar instead of primary
  remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
  add_action( 'genesis_sidebar', function() {
    genesis_widget_area( 'series-sidebar', array() );
  });
}

// Remove post-info and post-meta
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

// Use featured image in place of title if present.
add_action( 'genesis_post_title_text', function( $text ) {
  $img = genesis_get_image('size=large');
  if ( $img ) {
    $text = $img;
  }
  return $text;
});

genesis();
