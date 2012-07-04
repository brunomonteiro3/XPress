<?php
/**
 * The floor framework was developed as more of a starting boilerplate for more customized 
 * WordPress sites. Extending the base functionality was the line of thought behind development. 
 * Many experts suggest using different plugins but I don't like the plugin mess that often 
 * results. I like to build out the functionality that clients need. 
 * 
 * Comments and uncomment the functionality you want. This framework wasn't intended for the 
 * average user with options in the dashboard.
 * 
 * @package WordPress 3.3
 * @author Andres Hermosilla
 * @since 0.1
 */


/**
 *  Function to load wp.extname.php extensions
 *  e.g. load_wp_ext('email'); loads wp.email.php from the extend folder
 */
function x_load_wp_ext($ext){
  $ext = DIR_EXTND.'/wp.'.$ext.'.php';
  if(file_exists($ext)){
    require_once($ext);
  }
}
/**
 * function prefix
 * x_ any function
 * xf_ custom filter
 * xa_ add custom action
 * xs_ add shortcode
 * 
 * 
 * 
 */

/**
 *  Constants for commonly accessed values
 */

define('IS_LIVE', false);
define('SITE_URL', get_bloginfo('url'));
define('TMPL_URL', get_bloginfo('template_url'));
define('DIR_TMPL', get_template_directory());
define('DIR_CACHE',DIR_TMPL.'/cache/');
define('DIR_EXTND',DIR_TMPL .'/extend/');
define('DIR_ADMIN',ABSPATH. 'wp-admin/');
define('URI',$_SERVER['REQUEST_URI']);
define('THUMBSIZE',12); // width x height

add_action( 'after_setup_theme', 'xa_setup' );

// Use for general/common WordPress core theme functions
function xa_setup(){
  

  register_nav_menus(
    array('menu-main'   => __( 'Menu - Main' )),
    array('menu-footer' => __( 'Menu - Footer' ))
  );
  
  

  add_image_size( 'thumb-portfolio', 440, 300, true ); 

  add_theme_support( 'post-formats', array('aside','gallery','link'));
  add_theme_support( 'post-thumbnails');
  add_theme_support( 'custom-background');
  add_theme_support( 'custom-header');
}

/**
 *  Functions that can't really be classified
 */
x_load_wp_ext('other');

/**
 * Remove menu items, dashboard widgets, RSS crap, etc.
 * 
 * @since 0.1
 */
x_load_wp_ext('cleanup');


/**
 * Important variables that are often used in conditionals to load functions.
 * 
 * @since 0.1
 */

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
 * The usual WordPress functions.php functions for theme support etc.
 * 
 * @since 0.1
 */

x_load_wp_ext('template');

/**
 * wp.nav.php - Menu's, sidebar menus, pagination, breadcrumbs are included in 
 * the nav extension. Define any standards WordPress custom menus below
 * 
 * @since 0.1
 */
x_load_wp_ext('nav');


/**
 * wp.media.php - Media related functions and filters are found in the 
 * media extensions. You can also find the [gallery] shortcode in here.
 * 
 * @since 0.1
 */

x_load_wp_ext('media');



/**
 * Functions that we only need to worry about if user is logged. 
 * The user may or may not be in the front end.
 * 
 * (current empty)
 * 
 * @since 0.1
 * @file  wp.is-logged-in.php
 */
if($is_logged_in !== 0){
  x_load_wp_ext('is-logged-in');
} else {

}

/**
 * Functions that we only load if user is in backend
 * 
 * @since 0.1
 */

if($is_backend){
  x_load_wp_ext('backend');
  
  // For admin backend only
  if($is_admin){
    x_load_wp_ext('is-admin');
  }

  // If the theme was just activated
  if (isset($_GET['activated'] ) && $pagenow == "themes.php" ){
    // hold activation message or redirect
    x_load_wp_ext('activate');
    // Check if theme has been setup and if anything needs to be 
    // run on first load
    x_load_wp_ext('install');
  }

} else {
  // Is front end
  // wp_deregister_script('jquery');
}

/**
 * Widget related functions - widget areas, admin widgets, etc.
 *  
 * @since 0.1
 * @file  wp.widgets.php
 */
x_load_wp_ext('widgets');

/**
 * Email related functions - i.e. enable HTML emails, setting custom 
 * password remind email etc.
 *  
 * @since 0.1
 * @file  wp.email.php
 */
x_load_wp_ext('email');

/**
 * Comments related functions - comments template, extra comment 
 * form fields, etc.
 *  
 * @since 0.1
 * @file  wp.comments.php
 */
x_load_wp_ext('comments');

/**
 * Define any (more generic) shortcodes here. The [gallery] shortcode 
 * is under media since it fits that category better.
 *  
 * @since 0.1
 * @file  wp.shortcodes.php
 */
x_load_wp_ext('shortcodes');

/**
 * User related functions such as customizing profile view or 
 * redirecting after login.
 *  
 * @since 0.1
 * @file  wp.user.php
 */
x_load_wp_ext('user');


/**
 * Options that the user/admin can adjust in the backend, like many custom themes have.
 *  
 * @since 0.1
 * @file  wp.options.php
 */
x_load_wp_ext('options');

/**
 * Checks for mobile devices and runs functions.
 * Pass in functions into the IS_MOBILE conditionals
 *
 * @since 0.1
 */
define('IS_MOBILE', x_is_mobile());

/**
 *  Targeting for mobile devices
 */
if(IS_MOBILE){
  add_filter('template_include', 'xf_template_mobile', 1, 1); 

  // One template handles all mobile requests
  function xf_template_mobile($template) { 
    global $post;
    return DIR_TMPL . '/mobile.php'; 
   }
}

/**
 * Debugging functions accessible on development sites
 * 
 *
 * @since 0.1
 */
if(!IS_LIVE){
  /*
  set in wp-config.php
  define('WP_DEBUG', true); // Turn debugging ON
  define('WP_DEBUG_DISPLAY', false); // Turn forced display OFF
  define('WP_DEBUG_LOG',     true);  // Turn logging to wp-content/debug.log ON
  */
  
  x_load_wp_ext('debug');
}
