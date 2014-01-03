<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'outreach', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'outreach' ) );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Outreach Pro Theme', 'outreach' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/outreach/' );
define( 'CHILD_THEME_VERSION', '3.0.0' );

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue Google fonts
add_action( 'wp_enqueue_scripts', 'outreach_google_fonts' );
function outreach_google_fonts() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:400,700', array(), CHILD_THEME_VERSION );
	
}

//* Enqueue Responsive Menu Script
add_action( 'wp_enqueue_scripts', 'outreach_enqueue_responsive_script' );
function outreach_enqueue_responsive_script() {

	wp_enqueue_script( 'outreach-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );

}

//* Add new image sizes
add_image_size( 'home-top', 1140, 460, TRUE );
add_image_size( 'home-bottom', 285, 160, TRUE );
add_image_size( 'sidebar', 300, 150, TRUE );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 100,
	'width'           => 340,
) );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'site-inner',
	'footer-widgets',
	'footer',
) );

//* Add support for 4-column footer widgets
add_theme_support( 'genesis-footer-widgets', 4 );

//* Set Genesis Responsive Slider defaults
add_filter( 'genesis_responsive_slider_settings_defaults', 'outreach_responsive_slider_defaults' );
function outreach_responsive_slider_defaults( $defaults ) {

	$args = array(
		'location_horizontal'             => 'Left',
		'location_vertical'               => 'bottom',
		'posts_num'                       => '4',
		'slideshow_excerpt_content_limit' => '100',
		'slideshow_excerpt_content'       => 'full',
		'slideshow_excerpt_width'         => '35',
		'slideshow_height'                => '460',
		'slideshow_more_text'             => __( 'Continue Reading', 'outreach' ),
		'slideshow_title_show'            => 1,
		'slideshow_width'                 => '1140',
	);

	$args = wp_parse_args( $args, $defaults );
	
	return $args;
}

//* Hook after post widget after the entry content
add_action( 'genesis_after_entry', 'outreach_after_entry', 5 );
function outreach_after_entry() {

	if ( is_singular( 'post' ) )
		genesis_widget_area( 'after-entry', array(
			'before' => '<div class="after-entry widget-area">',
			'after'  => '</div>',
		) );

}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'outreach_author_box_gravatar_size' );
function outreach_author_box_gravatar_size( $size ) {

    return '80';
    
}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'mpp_remove_comment_form_allowed_tags' );
function mpp_remove_comment_form_allowed_tags( $defaults ) {
	
	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Add the sub footer section
add_action( 'genesis_before_footer', 'outreach_sub_footer', 5 );
function outreach_sub_footer() {

	if ( is_active_sidebar( 'sub-footer-left' ) || is_active_sidebar( 'sub-footer-right' ) ) {
		echo '<div class="sub-footer"><div class="wrap">';
		
		   genesis_widget_area( 'sub-footer-left', array(
		       'before' => '<div class="sub-footer-left">',
		       'after'  => '</div>',
		   ) );
	
		   genesis_widget_area( 'sub-footer-right', array(
		       'before' => '<div class="sub-footer-right">',
		       'after'  => '</div>',
		   ) );
	
		echo '</div><!-- end .wrap --></div><!-- end .sub-footer -->';	
	}
	
}

add_action( 'init', 'outreach_cleanup_hooks', 99 );
function outreach_cleanup_hooks() {
    remove_action ('wp_head', 'mbsb_enqueue_frontend_scripts_and_styles');
}

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'home-top',
	'name'        => __( 'Home - Top', 'outreach' ),
	'description' => __( 'This is the top section of the Home page.', 'outreach' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-bottom',
	'name'        => __( 'Home - Bottom', 'outreach' ),
	'description' => __( 'This is the bottom section of the Home page.', 'outreach' ),
) );
genesis_register_sidebar( array(
	'id'          => 'after-entry',
	'name'        => __( 'After Entry', 'outreach' ),
	'description' => __( 'This is the after entry widget area.', 'outreach' ),
) );
genesis_register_sidebar( array(
	'id'          => 'sub-footer-left',
	'name'        => __( 'Sub Footer - Left', 'outreach' ),
	'description' => __( 'This is the left section of the sub footer.', 'outreach' ),
) );
genesis_register_sidebar( array(
	'id'          => 'sub-footer-right',
	'name'        => __( 'Sub Footer - Right', 'outreach' ),
	'description' => __( 'This is the right section of the sub footer.', 'outreach' ),
) );
genesis_register_sidebar( array(
	'id'          => 'sermon-right',
	'name'        => __( 'Sermon Sidebar - Right', 'outreach' ),
	'description' => __( 'This is the right section of Sermon pages.', 'outreach' ),
) );
genesis_register_sidebar( array(
	'id'          => 'about-bottom',
	'name'        => __( 'About - Bottom', 'outreach' ),
	'description' => __( 'This is the bottom section of the About page.', 'outreach' ),
) );
