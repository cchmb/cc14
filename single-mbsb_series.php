<?php

add_action( 'genesis_meta', 'outreach_series_genesis_meta' );
function outreach_series_genesis_meta() {
	//* Remove post-info and post-meta
	remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
	remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
}

genesis();
