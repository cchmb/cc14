<?php

remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', function() {
  extract( ctfw_person_data() );
  echo '<p class="position">' . $position . '</p>';
}, 12 );

genesis();
