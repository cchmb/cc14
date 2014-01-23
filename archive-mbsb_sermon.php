<?php

add_action( 'genesis_meta', 'cc14_sermon_genesis_meta' );
function cc14_sermon_genesis_meta() {
  //* Remove post-meta
  remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

  remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

  remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
  add_action( 'genesis_entry_header', 'genesis_do_post_image', 8 );

  add_filter( 'genesis_get_image', 'cc14_sermon_youtube_image', 10, 6 );

  add_action( 'genesis_before_loop', 'cc14_sermon_before_loop' );
  add_filter( 'genesis_after_loop', 'cc14_sermon_series' );

  remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );
}


function cc14_sermon_before_loop() {
  echo '<section id="latest-sermons">';
  echo '  <h1 class="entry-title">Latest Sermons</h1>';
}

function cc14_sermon_youtube_image( $output, $args, $id, $html, $url, $src ) {
  if ( $output == "" ) {
    global $post;
    $sermon = new mbsb_sermon($post->ID);
    foreach ($sermon->attachments->get_attachments() as $k => $attachment) {
        if (strstr($attachment->get_url(), 'youtube.com') !== false) {
          parse_str( parse_url( $attachment->get_url(), PHP_URL_QUERY ) );
          if ($v) {
            $output = '<img src="http://img.youtube.com/vi/' . $v . '/mqdefault.jpg" />';
          }
        }
    }
  }

  return $output;
}

function cc14_sermon_series() {
  echo '</section>';
  echo '<section id="series">';
  echo '  <h1 class="entry-title">Sermon Series</h1>';

  //genesis_reset_loops();
  remove_filter( 'genesis_get_image', 'cc14_sermon_youtube_image', 10, 6 );
  remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

  genesis_custom_loop( array(
    'posts_per_page' => -1, 'post_type' => 'mbsb_series',
    'orderby' => 'date', 'order' => 'desc',
  ) );

  echo '</section>';
}

genesis();
