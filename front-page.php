<?php
/**
 * This file adds the Home Page to the CC14 Theme.
 *
 * @author StudioPress
 * @package CC14
 * @subpackage Customizations
 */

add_action( 'genesis_meta', 'cc14_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function cc14_home_genesis_meta() {

	if ( is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-bottom' ) ) {

		//* Force full-width-content layout setting
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
		
		//* Add cc14-home body class
		add_filter( 'body_class', 'cc14_body_class' );
		
		//* Remove breadcrumbs
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		//* Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );
		
		//* Add home top widgets
		add_action( 'genesis_loop', 'cc14_home_top_widgets' );

		//* Add home bottom widgets
		add_action( 'genesis_before_footer', 'cc14_home_bottom_widgets', 1 );

	}

}

function cc14_body_class( $classes ) {

	$classes[] = 'cc14-home';
	return $classes;
	
}

function cc14_home_top_widgets() {

	genesis_widget_area( 'home-top', array(
		'before' => '<div class="home-top widget-area">',
		'after'  => '</div>',
	) );
	
}

function cc14_home_bottom_widgets() {
	
	genesis_widget_area( 'home-bottom', array(
		'before' => '<div class="home-bottom widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

genesis();
