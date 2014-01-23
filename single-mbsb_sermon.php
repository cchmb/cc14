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

// Remove post-meta
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

// Use custom entry content
remove_filter('the_content', 'mbsb_provide_content');
add_filter('genesis_entry_content', function() {
    global $post;
    $sermon = new mbsb_sermon($post->ID);

    foreach ($sermon->attachments->get_attachments() as $k => $attachment) {
        if (strstr($attachment->get_url(), 'youtube.com') !== false) {
          $video = $attachment;
        } else if (substr($attachment->get_mime_type(), 0, 5) == "audio") {
          $audio = $attachment;
        }
    }

    if ($video) {
      parse_str( parse_url( $video->get_url(), PHP_URL_QUERY ) );
      if ($v) { ?>
  <section class="sermon_video">
    <div class="wrap">
      <iframe src="//www.youtube.com/embed/<?php esc_attr_e($v) ?>" frameborder="0" allowfullscreen></iframe>
    </div>
    <p class="download_link"><a href="<?php esc_attr_e($video->get_url()) ?>">Watch on YouTube</a></p>
  </section>
      <?php }
    }

    if ($audio) { ?>
      <section class="sermon_audio"><h3>Audio only</h3>
        <?php echo do_shortcode('[audio src="' . $audio->get_url() . '"]'); ?>
        <p class="download_link"><a href="<?php esc_attr_e($audio->get_url()) ?>">Download audio file</a></p>
      </section>
    <?php }
});

genesis();
