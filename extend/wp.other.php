<?php

/**
 * LESS compiler using LESSphp for nested styling
 *
 * 
 */

include_once( DIR_EXTND .'libs/lessify.inc.php');

$style = array(
	'less' 	=> 'site.less',
	'css'	=> 'site.css'
);

// Handles LESS compiling
function auto_compile_less($less_file, $css_file) {
  
  // Handles file relativity issues;
  $cache_file  = DIR_CACHE . $css_file .".cache";
  $less_file = DIR_TMPL. '/' . $less_file;
  $css_file  = DIR_TMPL . '/' . $css_file;
  
 
  
  if (file_exists($cache_file) && IS_LIVE) {
    $cache = unserialize(file_get_contents($cache_file));
  } else {
    $cache = $less_file;
  }
  
  $new_cache = lessc::cexecute($cache);

  if (!is_array($cache) || $new_cache['updated'] > $cache['updated']){
    
    // Compress CSS
    require_once(DIR_EXTND.'/libs/CSS_Compress.php');
    $compress = new CSS_Compress($css_file);
    $compiled = $compress::replace($new_cache['compiled']);

    file_put_contents($cache_file, serialize($new_cache));
    file_put_contents($css_file, $compiled);
  }
}
auto_compile_less($style['less'], $style['css']);



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
add_action('shutdown','before_shutdown');
function before_shutdown(){}
*/