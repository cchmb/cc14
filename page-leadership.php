<?php

// loop over people after normal content
add_action( 'genesis_after_loop', function() {
  remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
  remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
  remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

  add_action( 'genesis_entry_header', 'genesis_do_post_image', 8 );
  add_action( 'genesis_entry_content', function() {
    extract( ctfw_person_data() );
    echo '<p>' . $position . '</p>';
  });

  echo '<div id="leadership-team">';
  genesis_custom_loop( array(
    'posts_per_page' => -1, 'post_type' => 'ctc_person',
    'orderby' => 'order', 'order' => 'asc',
  ) );
  echo '</div>';
}, 11);

genesis();
