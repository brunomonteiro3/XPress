<?php
/**
 * Base functions.php for WordPress themes
 *
 * @package WordPress 3.3
 * @author  Andres Hermosilla
 */


/**
 * Common functions, variables, front end magic, shortcodes
 * 
 * 
 * 
 * 
 */

// Commonly called functions into constants
define('SITE_URL', get_bloginfo('url'));
define('TMPL_URL', get_bloginfo('template_url'));
define('DIR_TMPL',get_template_directory());
define('DIR_CACHE',DIR_TMPL.'/cache/');
define('DIR_EXTND',DIR_TMPL .'/extend/');
define('URI',$_SERVER['REQUEST_URI']);
define('IS_MOBILE', is_mobile());


function site_shortcode($atts) {
   extract(shortcode_atts(array(
       'type' => '',
   ), $atts));
   switch ($type) {
    case 'url':
        echo "i equals 0";
        break;
    case 1:
        echo "i equals 1";
        break;
    case 2:
        echo "i equals 2";
        break;
    }
   return SITE_URL;
}
add_shortcode('site', 'site_shortcode');


// Kill WYSIWYG
// add_filter('user_can_richedit' , create_function('' , 'return false;') , 50);

// Based on user agent detect if mobile device
// http://www.dannyherran.com/2011/02/detect-mobile-browseruser-agent-with-php-ipad-iphone-blackberry-and-others/
function is_mobile(){
  if(preg_match('/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipad|ipaq|ipod|j2me|java|midp|mini|mmp|mobi|motorola|nec-|nokia|palm|panasonic|philips|phone|sagem|sharp|sie-|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i', $_SERVER['HTTP_USER_AGENT'])){
    return true;
  } else {
    return false;
  }
}

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
  function search_hilighter($content, $terms) {
    $do_not_highlight = array( "a", "A", "is", "Is", "the", "The", "and", "And" );
    $search_term = $terms;
    foreach ($search_term as $search_t) {
            preg_match_all("/$search_t+/i", $content, $matches);
            foreach ($matches as $match) {
                if (!in_array($match[0],$do_not_highlight)) {
                $content = str_replace($match[0], "[m]" . $match[0] . "[mm]", $content);
                }
            }
        }
 
        $find = array("[m]","[mm]");
        $replace = array('<span class="hilite-result">','</span>');
        $highlighted_content = str_replace($find,$replace,$content);   
    echo $highlighted_content;
 
  }
// So you can send HTML emails, mate!  
function mail_content_type(){
    return "text/html";
}
add_filter( 'wp_mail_content_type','mail_content_type' );
// Find current user
// $user =  wp_get_current_user();

// Menu & Thumbnail support
add_theme_support( 'nav-menus' );
add_theme_support( 'post-thumbnails' );

// Menu setup
add_action( 'init', 'custom_menus');
function custom_menus() {
  register_nav_menus(
    array('menu-main'   => __( 'Menu - Main' )),
    array('menu-footer' => __( 'Menu - Footer' ))
  );

}

// Enable shortcodes in widget area
add_filter('widget_text', 'do_shortcode');

// Add Sidebar    
if (function_exists('register_sidebar')) {
      register_sidebar(array(
        'name' => 'Sidebar Widgets',
        'id'   => 'sidebar-widgets',
        'description'   => 'These are widgets for the sidebar.',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>'
      ));
}

// New custom excerpt length
function update_excerpt_length($length) {
  return 20;
}
add_filter('excerpt_length', 'update_excerpt_length');

// Remove automatic insertion of jQuery
if (!is_admin()) {
  wp_deregister_script('jquery');
}

// Kill the admin bar
show_admin_bar(false);

// Remove junk from wp_head()
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

// Disabling Feeds
function fb_disable_feed() {
  wp_die(__('<h1>Feed not available, please visit our <a href="'.get_bloginfo('url').'">Home Page</a>!</h1>'));
}
add_action('do_feed',      'fb_disable_feed', 1);
add_action('do_feed_rdf',  'fb_disable_feed', 1);
add_action('do_feed_rss',  'fb_disable_feed', 1);
add_action('do_feed_rss2', 'fb_disable_feed', 1);
add_action('do_feed_atom', 'fb_disable_feed', 1);

// Handles outputting document title
function the_doc_title(){
  global $paged;
  print_r($s);
 echo '[';
 if (function_exists('is_tag') && is_tag()) {
      single_tag_title("Tag Archive for &quot;"); echo '&quot; - '; 
    } elseif (is_archive()){
      wp_title(''); echo ' In the Past - '; 
    } elseif (is_search()) {
          echo 'Search for &quot;'. wp_specialchars(get_search_query()) .'&quot; - '; 
        
    } elseif (!(is_404()) && (is_single()) || (is_page())) {
      wp_title(''); echo ' - '; 
    } elseif (is_404()) {
        echo 'Not Found - '; 
    } if (is_home()) {
      bloginfo('name'); echo ' - '; bloginfo('description'); 
    } else {
      bloginfo('name'); 
    }

    if ($paged > 1) {
             echo ' - page '. $paged; 
    }
   echo ' ]';
}

function page_group_menu(){
  global $post;
  $cache_file = DIR_CACHE .'pm.'.$post->ID.'.html.cache';
  if(!file_exists($cache_file)){
    $pages = "<!-- [cached]  ".date("F j, Y, g:i a") ." -->\n";
    $pages .= wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");
    
    if(!$pages){
      $pages .= wp_list_pages("title_li=&include=".$post->ancestors[0]."&echo=0");
      $pages .= wp_list_pages("title_li=&child_of=".$post->ancestors[0]."&exclude=".$post->ID."&echo=0");
    }

    $pages = "<!-- [cached] -->\n";
    
    file_put_contents($cache_file, $pages);
  }
  include_once($cache_file);
}

add_action('save_post','flush_cache');

/**
 * Backend functions and variables
 * 
 * 
 * 
 * 
 */

// Default content for editor
// http://www.wpbeginner.com/wp-tutorials/how-to-add-default-content-in-your-wordpress-post-editor/
add_filter( 'default_content', 'editor_content' );

function editor_content( $content ) {
  $content = "Type out or paste (do not paste from Word) content here. \n\nTo add images click above for Upload/Insert on the photo icon\n\nTo add a thumbnail that is associated with the item  click 'Set feaured image' on the right side";
  return $content;
}

// Adjusting profile fields
add_filter('user_contactmethods','profile_fields',10,1);
 
function profile_fields( $contactmethods ) {
  unset($contactmethods['aim']);
  unset($contactmethods['jabber']);
  unset($contactmethods['yim']);

  // $contactmethods['twitter'] = 'Twitter';
  // $contactmethods['facebook'] = 'Facebook';
  return $contactmethods;
}


// Remove Comments and Links manager
add_action( 'admin_menu', 'update_menu' );

function update_menu() {
  // remove_menu_page('link-manager.php');
  // remove_menu_page('themes.php');
  // remove_menu_page('plugins.php');
  // remove_menu_page('edit-comments.php');
}


// Kill dashboard widgets
add_action('wp_dashboard_setup', 'update_dashboard_widgets');

function update_dashboard_widgets() {
  global $wp_meta_boxes;
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
}

// Find current page - ideal for backend scripts
global $pagenow;
$is_logged_in = is_user_logged_in();
$is_backend = is_admin();


// For logged in users only
if($is_logged_in){
  
}

// For logged in and dashboard
if($is_backend ){

    
    wp_register_script('admin_extend', DIR_TMPL."/js/admin.js");
    wp_enqueue_script('admin_extend');

    /*
    // To add adminstration pages/tabs to backend
    include_once(DIR_EXTND.'class.wp_options.php');
    $options = new WP_options();
    $options->addPage('Options','Options','manage_options','options-plus','options_plus');
    $options->init();
    function options_plus(){
      echo 'Hello World';
    }
    */
 
}

// function for caching menus
function menu_cache($args = array()){

  if(isset($args['menu_id'])){
    $menu_file = __DIR__ . '/cache/'.$args['menu_id'].'.html.cache';
      if(!file_exists($menu_file)){
          $_args = array(
            'menu'          => '', 
            'container'     => '',
            'container_id'  => '',
            'fallback_cb'   => 'wp_page_menu',
            'echo'          => false,
          );
          
          foreach($args as $arg => $value) {
            $_args[$arg] = $value;
          }
      
          
          $menu = "<!-- [cached]  ".date("F j, Y, g:i a") ." -->\n";
          $menu .= wp_nav_menu($_args);
          $menu .= "\n<!-- // [cached] -->\n"; 

        file_put_contents($menu_file, $menu);
      }

      include_once($menu_file);
    } else {
       wp_nav_menu($args);
    }
}
// Flushes menu cache if menus are changed
if(isset($_POST['action']) && $pagenow === 'nav-menus.php'){
  array_map('unlink', glob(DIR_CACHE.'*.html.cache'));
}


function flush_cache(){
   array_map('unlink', glob(DIR_CACHE.'*'));
}

/**
 * LESS compiler using LESSphp for nested styling
 *
 * 
 */

include_once( DIR_EXTND .'lessify.inc.php');

$style = array(
	'less' 	=> 'site.less',
	'css'	=> 'site.css'
);



// Handles LESS compiling
function auto_compile_less($less_file, $css_file) {
  
  // Handles file relativity issues;
  $cache_file  = DIR_CACHE . $css_file .".cache";
  $less_file = __DIR__ . '/' . $less_file;
  $css_file  = __DIR__ . '/' . $css_file;
  
 
  // Comment for testing/ uncomment for live
  // if (file_exists($cache_file)) {
  //  $cache = unserialize(file_get_contents($cache_file));
  // } else {
    $cache = $less_file;
  //}


  $new_cache = lessc::cexecute($cache);

  if (!is_array($cache) || $new_cache['updated'] > $cache['updated']) {
    file_put_contents($cache_file, serialize($new_cache));
    file_put_contents($css_file, $new_cache['compiled']);
  }
}

auto_compile_less($style['less'], $style['css']);

// http://www.kriesi.at/archives/how-to-build-a-wordpress-post-pagination-without-plugin
function post_pagination($pages = '', $range = 3){  
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == ''){
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages){
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {
         echo "<div class='pagination'>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div>\n";
     }
}

/*
// Use if you have private or protected content
function the_title_trim($title) {
  $title = attribute_escape($title);
  $findthese = array(
    '#Protected:#',
    '#Private:#'
  );
  $replacewith = array(
    '', // What to replace "Protected:" with
    '' // What to replace "Private:" with
  );
  $title = preg_replace($findthese, $replacewith, $title);
  return $title;
}
add_filter('the_title', 'the_title_trim');
*/

/*
// Add admin logo to header
function logo_admin() {
  echo '<style type="text/css">
          #header-logo { background-image: url('.TMPL_URL.'/css/img/admin_logo.png) !important; }
        </style>';
}
add_action('admin_head', 'logo_admin');
*/

/*
// Add logo to login page
function logo_login() {
    echo '<style type="text/css">
        h1 a { background-image:url('.TMPL_URL.'/images/login_logo.png) !important; }
    </style>';
}
add_action('login_head', 'logo_login');

*/


/*
// Use if you need to modify menu output
//http://www.kriesi.at/archives/improve-your-wordpress-navigation-menu-output
class menu_extended extends Walker_Nav_Menu
{
      function start_el(&$output, $item, $depth, $args)
      {
           global $wp_query;
           $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

           $class_names = $value = '';

           $classes = empty( $item->classes ) ? array() : (array) $item->classes;

           $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
           $class_names = ' class="'. esc_attr( $class_names ) . '"';

           $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

           $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
           $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
           $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
           $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

           $prepend = '<strong>';
           $append = '</strong>';
           $description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';

           if($depth != 0)
           {
                     $description = $append = $prepend = "";
           }

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
            $item_output .= $description.$args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
            }
}

// Usage
wp_nav_menu( array(
 'container' =>false,
 'menu_class' => 'nav',
 'echo' => true,
 'before' => '',
 'after' => '',
 'link_before' => '',
 'link_after' => '',
 'depth' => 0,
 'walker' => new menu_extended())
 );

*/

/*
// Redirect admins to the dashboard and other users elsewhere after login
add_filter( 'login_redirect', 'login_redirect', 10, 3 );
function login_redirect( $redirect_to, $request, $user ) {

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
*/

// Comment out on live site
include_once( DIR_EXTND .'debug.php');
/*
if(!$is_backend){
  
}

add_action('shutdown','before_shutdown');

function before_shutdown(){
 
}
*/


?>
