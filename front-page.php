<?php
/**
 * This file adds the Home Page to the CC14 Theme.
 *
 * @author StudioPress
 * @package CC14
 * @subpackage Customizations
 */

/** Add widget support for homepage. If no widgets active, display the default loop.  */
if ( is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-bottom' ) ) {
  // Force full-width-content layout setting
  add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

  // Add cc14-home body class
  add_filter( 'body_class', function( $classes ) {
    $classes[] = 'cc14-home';
    return $classes;
  });

  // Remove breadcrumbs
  remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

  // Remove the default Genesis loop
  remove_action( 'genesis_loop', 'genesis_do_loop' );

  // Add home top widgets
  add_action( 'genesis_loop', function() {
    genesis_widget_area( 'home-top', array(
      'before' => '<div class="home-top widget-area">',
      'after'  => '</div>',
    ) );
  });

  // Add home bottom widgets
  add_action( 'genesis_before_footer', function() {
    genesis_widget_area( 'home-bottom', array(
      'before' => '<div class="home-bottom widget-area"><div class="wrap">',
      'after'  => '</div></div>',
    ) );
  }, 1 );
}

genesis();
