<?php

add_shortcode('headshot', function( $atts, $content ) {
  $defaults = array( 'id' => 0, 'name' => '' );
  $atts = shortcode_atts( $defaults, $atts, 'headshot' );
  extract($atts);

  global $wp_query, $post;
  $q = array('post_type' => 'mbsb_preacher');
  if ( $id ) {
    $q['page_id'] = $id;
  } else if ($name) {
    $q['name'] = $name;
  }

  $wp_query = new WP_Query($q);

  ob_start();
  while ( have_posts() ) : the_post();
?>
  <section id="<?php esc_attr_e($post->post_name) ?>" class="headshot">
    <a href="<?php the_permalink() ?>"><img width="300" height="300"
      src="<?php genesis_image('format=url') ?>" /></a>
    <h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
    <p><em><?php esc_html_e( get_post_meta($post->ID, 'position', true) ); ?></em></p>
  </section>
<?php endwhile;
  $output = ob_get_clean();

  wp_reset_query();

  return apply_filters('cc14_leadership_headshot', $output, $atts);
});

genesis();
