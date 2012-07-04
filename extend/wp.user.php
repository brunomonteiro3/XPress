<?php


// Redirect admins to the dashboard and other users elsewhere after login
// add_filter( 'login_redirect', 'xf_login_redirect', 10, 3 );
function xf_login_redirect( $redirect_to, $request, $user ) {

  // Set redirects for roles
  $redirects = array(
      'administrator' => SITE_URL .'/wp-adminss/', 
      'editor'        => SITE_URL .'/editors/',  
      'author'        => SITE_URL .'/wp-admin/',  
      'contributor'   => SITE_URL .'/wp-admin/', 
      'subscriber'    => SITE_URL .'/subscriber/',
      'default'       => SITE_URL 
  );

  $return = '';

  if(is_array($user->roles)){
    if(array_key_exists($user->roles[0], $redirects)){
      $return = $redirects[$user->roles[0]];
    } else {
      $return = $redirects['default'];
    } 
      return $return;
    }
}


// Adjusting profile fields
add_filter('user_contactmethods','xf_profile_fields',10,1);
 
function xf_profile_fields( $contactmethods ) {
  unset($contactmethods['aim']);
  unset($contactmethods['jabber']);
  unset($contactmethods['yim']);

  // $contactmethods['twitter'] = 'Twitter';
  // $contactmethods['facebook'] = 'Facebook';
  return $contactmethods;
}
