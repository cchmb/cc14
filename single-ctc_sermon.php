<?php

// Add sermon sidebar widgets if present
if ( is_active_sidebar( 'sermon-sidebar' ) ) {
  add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

  // Display sermon sidebar instead of primary
  remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
  add_action( 'genesis_sidebar', function() {
    genesis_widget_area( 'sermon-sidebar', array() );
  });
}

genesis();
