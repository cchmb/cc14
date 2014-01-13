<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'cc14', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'cc14' ) );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Calvary Chapel HMB 2014', 'cc14' ) );
define( 'CHILD_THEME_URL', 'http://www.cchmb.org/' );

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue Google fonts
add_action( 'wp_enqueue_scripts', 'cc14_google_fonts' );
function cc14_google_fonts() {
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:400,700', array(), CHILD_THEME_VERSION );
}

//* Enqueue Responsive Menu Script
add_action( 'wp_enqueue_scripts', 'cc14_enqueue_responsive_script' );
function cc14_enqueue_responsive_script() {
	wp_enqueue_script( 'cc14-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );
}

// Remove all image sizes.
add_filter( 'intermediate_image_sizes_advanced', '__return_empty_array', 99 );

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
add_filter( 'genesis_responsive_slider_settings_defaults', 'cc14_responsive_slider_defaults' );
function cc14_responsive_slider_defaults( $defaults ) {

	$args = array(
		'location_horizontal'             => 'Left',
		'location_vertical'               => 'bottom',
		'posts_num'                       => '4',
		'slideshow_excerpt_content_limit' => '100',
		'slideshow_excerpt_content'       => 'full',
		'slideshow_excerpt_width'         => '35',
		'slideshow_height'                => '460',
		'slideshow_more_text'             => __( 'Continue Reading', 'cc14' ),
		'slideshow_title_show'            => 1,
		'slideshow_width'                 => '1140',
	);

	$args = wp_parse_args( $args, $defaults );

	return $args;
}

//* Hook after post widget after the entry content
add_action( 'genesis_after_entry', 'cc14_after_entry', 5 );
function cc14_after_entry() {

	if ( is_singular( 'post' ) )
		genesis_widget_area( 'after-entry', array(
			'before' => '<div class="after-entry widget-area">',
			'after'  => '</div>',
		) );

}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'cc14_author_box_gravatar_size' );
function cc14_author_box_gravatar_size( $size ) {

    return '80';

}

add_filter( 'post_thumbnail_html', 'cc14_post_image_html', 10, 3 );
function cc14_post_image_html( $html, $post_id, $post_image_id ) {
    $html = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '">' . $html . '</a>';
    return $html;
}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'mpp_remove_comment_form_allowed_tags' );
function mpp_remove_comment_form_allowed_tags( $defaults ) {

	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Add the sub footer section
add_action( 'genesis_before_footer', 'cc14_sub_footer', 5 );
function cc14_sub_footer() {

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

add_action( 'init', 'cc14_cleanup_hooks', 99 );
function cc14_cleanup_hooks() {
	remove_action ('wp_head', 'mbsb_enqueue_frontend_scripts_and_styles');
}

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'home-top',
	'name'        => __( 'Home - Top', 'cc14' ),
	'description' => __( 'This is the top section of the Home page.', 'cc14' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-bottom',
	'name'        => __( 'Home - Bottom', 'cc14' ),
	'description' => __( 'This is the bottom section of the Home page.', 'cc14' ),
) );
genesis_register_sidebar( array(
	'id'          => 'after-entry',
	'name'        => __( 'After Entry', 'cc14' ),
	'description' => __( 'This is the after entry widget area.', 'cc14' ),
) );
genesis_register_sidebar( array(
	'id'          => 'sub-footer-left',
	'name'        => __( 'Sub Footer - Left', 'cc14' ),
	'description' => __( 'This is the left section of the sub footer.', 'cc14' ),
) );
genesis_register_sidebar( array(
	'id'          => 'sub-footer-right',
	'name'        => __( 'Sub Footer - Right', 'cc14' ),
	'description' => __( 'This is the right section of the sub footer.', 'cc14' ),
) );
genesis_register_sidebar( array(
	'id'          => 'sermon-sidebar',
	'name'        => __( 'Sermon - Primary Sidebar', 'cc14' ),
	'description' => __( 'This is the primary sidebar of Sermon pages.', 'cc14' ),
) );
genesis_register_sidebar( array(
	'id'          => 'about-bottom',
	'name'        => __( 'About - Bottom', 'cc14' ),
	'description' => __( 'This is the bottom section of the About page.', 'cc14' ),
) );
genesis_register_sidebar( array(
	'id'          => 'preacher-sidebar',
	'name'        => __( 'Preacher - Primary Sidebar', 'cc14' ),
	'description' => __( 'This is the primary sidebar of Preacher pages.', 'cc14' ),
) );
genesis_register_sidebar( array(
	'id'          => 'series-sidebar',
	'name'        => __( 'Sermon Series - Primary Sidebar', 'cc14' ),
	'description' => __( 'This is the primary sidebar of Sermon Series pages.', 'cc14' ),
) );
