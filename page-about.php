<?php

// Add about bottom widgets if present
if ( is_active_sidebar( 'about-bottom' ) ) {
  add_action( 'genesis_after_entry', function() {
    genesis_widget_area( 'about-bottom', array(
      'before' => '<div class="about-bottom widget-area"><div class="wrap">',
      'after'  => '</div></div>',
    ) );
  }, 1 );
}

genesis();
