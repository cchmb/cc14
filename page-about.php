<?php

add_action( 'genesis_meta', 'outreach_about_genesis_meta' );
function outreach_about_genesis_meta() {
	if ( is_active_sidebar( 'about-bottom' ) ) {
		//* Add about bottom widgets
		add_action( 'genesis_after_entry', 'outreach_about_bottom_widgets', 1 );
	}
}

function outreach_about_bottom_widgets() {
	genesis_widget_area( 'about-bottom', array(
		'before' => '<div class="about-bottom widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );
}

genesis();
