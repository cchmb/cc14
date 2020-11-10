<?php

// Remove post-meta
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

// Display image above title
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 8 );

add_action( 'genesis_before_loop', function() {
  echo '
  <section id="latest-sermons">
    <h1 class="entry-title">Latest Sermons</h1>
    <div class="sermons">';
});
add_filter( 'genesis_after_loop', function() {
  echo '
    </div>
  </section>
  <section id="series">
    <h1 class="entry-title">Sermon Series</h1>
    <div class="sermons">';

  $series = apply_filters('taxonomy-images-get-terms', '', ['taxonomy'=>'ctc_sermon_series', 'having_images'=>false]);
  foreach( $series as $s ) {
    $link = get_term_link($s);
    $image = wp_get_attachment_image($s->image_id, 'medium');
    echo '
  <article class="sermon-series">
  <a href="' . esc_attr__($link) .'">' . $image .'</a>
    <h2 class="entry-title"><a href="' . esc_attr__($link) .'">'. esc_html__($s->name) .'</a></h2>
  </article>';
  }
  echo '
    </div>
  </section>';
});

genesis();
