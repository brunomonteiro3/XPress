<?php
/**
 * Base functions.php for WordPress themes
 *
 * @package WordPress 3.3
 * @author  Andres Hermosilla
 */


define('IS_LIVE', false);

function load_wp_ext($ext){
  if(file_exists(DIR_EXTND.'/wp.'.$ext.'.php')){
    require_once(DIR_EXTND.'/wp.'.$ext.'.php');
  }
}

// Commonly called functions into constants
define('SITE_URL', get_bloginfo('url'));
define('TMPL_URL', get_bloginfo('template_url'));
define('DIR_TMPL', get_template_directory());
define('DIR_CACHE',DIR_TMPL.'/cache/');
define('DIR_EXTND',DIR_TMPL .'/extend/');
define('DIR_ADMIN',ABSPATH. 'wp-admin/');
define('URI',$_SERVER['REQUEST_URI']);

// Functions that can't really be classified
load_wp_ext('other');

define('IS_MOBILE', is_mobile());


// Find current page - ideal for backend scripts
global $pagenow;

// (object) Check who current user is - if none returns 0
$user =  wp_get_current_user();

// (boolean) Check if visitor is logged in
$is_logged_in = is_user_logged_in();

// (boolean) Check if in dashboard
$is_backend = is_admin();

// (boolean) Check if is admin user
$is_admin = current_user_can('manage_options');



/**
 *    Usual WordPress ish
 * 
 * 
 */
// Menu & Thumbnail support
add_theme_support( 'nav-menus' );
add_theme_support( 'post-thumbnails' );


load_wp_ext('nav');

// Menu setup
add_action( 'init', 'custom_menus');
function custom_menus() {
  register_nav_menus(
    array('menu-main'   => __( 'Menu - Main' )),
    array('menu-footer' => __( 'Menu - Footer' ))
  );
}




/**
 *    Media
 *    
 * 
 * 
 */

load_wp_ext('media');

if (function_exists( 'add_image_size' ) ) { 
  add_image_size( 'pet_thumb', 440, 300, true ); 

// For logged in users only
if($is_logged_in !== 0){
  load_wp_ext('is-logged-in');
} else {

}

// For logged in and dashboard
if($is_backend){
  load_wp_ext('backend');

  if (isset($_GET['activated'] ) && $pagenow == "themes.php" ){
    load_wp_ext('install');
  }
} else {
  wp_deregister_script('jquery');
}

load_wp_ext('widgets');
load_wp_ext('email');
load_wp_ext('comments');
load_wp_ext('shortcodes');
load_wp_ext('user');

/*
if(IS_MOBILE){
  add_filter('template_include', 'template_mobile', 1, 1); 

  // make one template handle all the mobile space
  function template_mobile($template) { 
    global $post;
    return DIR_TMPL . '/mobile.php'; 
   }
}
*/


if(!IS_LIVE){
  /*
  set in wp-config.php
  define('WP_DEBUG', true); // Turn debugging ON
  define('WP_DEBUG_DISPLAY', false); // Turn forced display OFF
  define('WP_DEBUG_LOG',     true);  // Turn logging to wp-content/debug.log ON
  */
  
  load_wp_ext('debug');
}


