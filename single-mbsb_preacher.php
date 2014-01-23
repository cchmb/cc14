<?php

// Add preacher sidebar widgets if present
if ( is_active_sidebar( 'preacher-sidebar' ) ) {
  add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

  // Display preacher sidebar instead of primary
  remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
  add_action( 'genesis_sidebar', function() {
    genesis_widget_area( 'preacher-sidebar', array() );
  });
}

// Remove post-info and post-meta
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

// Add title (Paster, Deacon, etc) below name.
add_action( 'genesis_entry_header', function() {
  global $post;
  $title = get_post_meta($post->ID, 'position', true);

  if ($title) {
    echo '<div class="title"><em>' . $title . '</em></div>';
  }
}, 12 );

genesis();
