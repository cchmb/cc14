<?php

add_action( 'genesis_meta', 'cc14_series_genesis_meta' );
function cc14_series_genesis_meta() {
  if ( is_active_sidebar( 'series-sidebar' ) ) {
    add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

    //* Display series sidebar instead of primary
    remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
    add_action( 'genesis_sidebar', 'cc14_series_sidebar_widgets' );
  }

  //* Remove post-info and post-meta
  remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
  remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

  add_action( 'genesis_post_title_text', 'cc14_series_title' );
}

function cc14_series_sidebar_widgets() {
  genesis_widget_area( 'series-sidebar', array() );
}

/** Use featured image in place of title if present. */
function cc14_series_title( $text ) {
  $img = genesis_get_image('size=large');
  if ( $img ) {
    $text = $img;
  }
  return $text;
}

genesis();
