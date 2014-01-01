<?php

add_action( 'genesis_meta', 'outreach_sermon_genesis_meta' );
function outreach_sermon_genesis_meta() {

	if ( is_active_sidebar( 'sermon-right' ) ) {
		//* Force content-sidebar layout setting
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

		//* Display sermon sidebar instead of primary
		remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
		add_action( 'genesis_sidebar', 'outreach_sermon_right_sidebar' );
	}

	//* Remove post-meta
	add_filter('genesis_post_meta', '__return_empty_string' );

	//* Use custom entry content
	remove_filter('the_content', 'mbsb_provide_content');
	add_filter('the_content', 'outreach_sermon_content');
}

function outreach_sermon_right_sidebar() {
	genesis_widget_area( 'sermon-right', array() );
}

function outreach_sermon_content($content) {
		global $post;
		$sermon = new mbsb_sermon($post->ID);
		$description = $content;

		foreach ($sermon->attachments->get_attachments() as $k => $attachment) {
				if (strstr($attachment->get_url(), 'youtube.com') !== false) {
						parse_str( parse_url( $attachment->get_url(), PHP_URL_QUERY ) );
						if ($v) {
								$video = '<div class="wrap"><iframe src="//www.youtube.com/embed/'. $v .'" frameborder="0" allowfullscreen></iframe></div>';
								$video .= '<p class="download_link"><a href="' . $attachment->get_url() . '">Watch on YouTube</a></p>';
						}
				} else if (substr($attachment->get_mime_type(), 0, 5) == "audio") {
						$audio = do_shortcode('[audio src="' . $attachment->get_url() . '"]');
						$audio .= '<p class="download_link"><a href="' . $attachment->get_url() . '">Download audio file</a></p>';
				}
		}

		if ($video) {
				$content .= '<section class="sermon_video">'.$video.'</section>';
		}
		$content .= '<section class="sermon_audio"><h3>Audio only</h3>'.$audio.'</section>';

		$content .= $widgets;

		return $content;
}

genesis();
