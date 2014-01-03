<?php

add_action( 'genesis_meta', 'cc14_sermon_genesis_meta' );
function cc14_sermon_genesis_meta() {
	//* Remove post-meta
	remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
}

genesis();
