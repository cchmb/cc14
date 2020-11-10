<?php

if ( is_active_sidebar( 'sermon-speaker-sidebar' ) ) {
  add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

  // Display speaker sidebar instead of primary
  remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
  add_action( 'genesis_sidebar', function() {
    genesis_widget_area( 'sermon-speaker-sidebar', array() );
  });
}

genesis();
