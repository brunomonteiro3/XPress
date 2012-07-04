<?php

// Hide default message and show install message
function xa_install_notice(){
  echo '<style>#message2{display:none !important;}</style>';
  echo '<div class="updated"><p>Thanks for installing the best theme ever!</p></div>';
}
     
add_action('admin_notices','xa_install_notice');
// Redirect to options page if need be
//wp_redirect( 'themes.php?page=theme_options_page' );

