<?php

// Default content for editor
// http://www.wpbeginner.com/wp-tutorials/how-to-add-default-content-in-your-wordpress-post-editor/
add_filter( 'default_content', 'editor_content' );

function editor_content( $content ) {
  $content = "Type out or paste (do not paste from Word) content here. \n\nTo add images click above for Upload/Insert on the photo icon\n\nTo add a thumbnail that is associated with the item  click 'Set feaured image' on the right side";
  return $content;
}


// Kill WYSIWYG
//add_filter('user_can_richedit' , create_function('' , 'return false;') , 50);


// Add admin logo to header
function logo_admin() {
  echo '<style type="text/css">';
  echo '#header-logo { background-image: url('.TMPL_URL.'/img/admin-logo.png) !important; }';
  echo '</style>';
}

add_action('admin_head', 'logo_admin');

// Add logo to login page
function logo_login() {
    echo '<style type="text/css">';
    echo 'h1 a { background-image:url('.TMPL_URL.'/img/login-logo.png) !important; }';
    echo '</style>';
}
add_action('login_head', 'logo_login');