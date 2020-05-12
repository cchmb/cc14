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
        } else if (strstr($attachment->get_url(), 'docs.google.com/presentation') !== false) {
          $slides = $attachment;
        } else if (substr($attachment->get_mime_type(), 0, 5) == "audio") {
          $audio = $attachment;
        }
    }

    if ($video) {
      parse_str( parse_url( $video->get_url(), PHP_URL_QUERY ) );
      if ($v) {
        $embed_url = "https://www.youtube.com/embed/" . $v;
        if ($t) {
          $embed_url .= "?start=" . $t;
        }
?>
  <section class="sermon_video">
    <div class="wrap">
      <iframe src="<?php esc_attr_e($embed_url) ?>" frameborder="0" allowfullscreen></iframe>
    </div>
    <p class="download_link"><a href="<?php esc_attr_e($video->get_url()) ?>">Watch on YouTube</a></p>
  </section>
      <?php }
    }

    if ($audio) { ?>
      <section class="sermon_audio"><h3>Audio</h3>
        <p><?php echo do_shortcode('[audio src="' . $audio->get_url() . '"]'); ?></p>
        <p class="download_link"><a href="<?php esc_attr_e($audio->get_url()) ?>">Download audio file</a></p>
      </section>
    <?php }

    if ($slides) {
      preg_match("#https://docs.google.com/presentation/d/([^/]+).*#", $slides->get_url(), $matches);
      if ($id = $matches[1]) { ?>
        <section class="sermon_slides"><h3>Sermon Slides</h3>
          <div class="wrap">
            <iframe src="https://docs.google.com/presentation/d/<?php esc_attr_e($id) ?>/embed" frameborder="0" allowfullscreen></iframe>
          </div>
        </section>
      <?php }
    }
}, 9);

genesis();
