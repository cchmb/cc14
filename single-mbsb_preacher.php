<?php

add_action( 'genesis_meta', 'cc14_preacher_genesis_meta' );
function cc14_preacher_genesis_meta() {
  if ( is_active_sidebar( 'preacher-sidebar' ) ) {
    add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

    //* Display preacher sidebar instead of primary
    remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
    add_action( 'genesis_sidebar', 'cc14_preacher_sidebar_widgets' );
  }

  //* Remove post-info and post-meta
  remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
  remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

  add_action( 'genesis_entry_header', 'cc14_preacher_title', 12 );
  //add_action( 'genesis_after_endwhile', 'cc14_preacher_sermons' );
}

function cc14_preacher_title() {
  global $post;
  $title = get_post_meta($post->ID, 'position', true);

  if ($title) {
    echo '<div class="title"><em>' . $title . '</em></div>';
  }
}

function cc14_preacher_sermons() {
  $preacher_id = get_queried_object_id();

  $args = array(
    'post_type' => 'mbsb_sermon',
    'meta_key' => 'preacher',
    'meta_value' => $preacher_id,
    'posts_per_page' => 10,
  );

  genesis_custom_loop( $args );
}

function cc14_preacher_sidebar_widgets() {
  genesis_widget_area( 'preacher-sidebar', array() );
}

genesis();
