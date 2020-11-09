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

add_filter('genesis_entry_content', function() {
    extract( ctfw_sermon_data() );

    if ($video) {
?>
  <section class="sermon_video">
    <div class="wrap">
      <?php echo $video_player; ?>
    </div>
    <p class="download_link"><a href="<?php esc_attr_e($video) ?>">Watch on YouTube</a></p>
  </section>
      <?php
    }

    if ($audio) { ?>
      <section class="sermon_audio"><h3>Audio</h3>
        <?php echo $audio_player; ?>
        <p class="download_link"><a href="<?php esc_attr_e($audio) ?>">Download audio file</a></p>
      </section>
    <?php }

    if ($slides) {
      preg_match("#https://docs.google.com/presentation/d/([^/]+).*#", $slides, $matches);
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
