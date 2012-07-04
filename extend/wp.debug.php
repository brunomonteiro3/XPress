<?php

/**
 * Debugging Tools and functions
 *
 */

/*
set in wp-config.php
define('WP_DEBUG', true); // Turn debugging ON
define('WP_DEBUG_DISPLAY', false); // Turn forced display OFF
define('WP_DEBUG_LOG',     true);  // Turn logging to wp-content/debug.log ON
*/
// var_dump(debug_backtrace());

// List all hooked function or find a specific function
function x_list_hooked_functions($tag=false){
 global $wp_filter;
 if ($tag) {
  $hook[$tag]=$wp_filter[$tag];
  if (!is_array($hook[$tag])) {
  trigger_error("Nothing found for '$tag' hook", E_USER_WARNING);
  return;
  }
 } else {
  $hook=$wp_filter;
  ksort($hook);
 }
 echo '<pre>';
 foreach($hook as $tag => $priority){
  echo "<br />&gt;&gt;&gt;&gt;&gt;\t<strong>$tag</strong><br />";
  ksort($priority);
  foreach($priority as $priority => $function){
  echo $priority;
  foreach($function as $name => $properties) echo "\t$name<br />";
  }
 }
 echo '</pre>';
 return;
}

// this can live in /themes/mytheme/functions.php, or maybe as a dev plugin?
// Ideally placed in header.php
function x_get_template_name() {
  foreach ( debug_backtrace() as $called_file ) {
    foreach ( $called_file as $index ) {
      if ( !is_array($index[0]) && strstr($index[0],'/themes/') && !strstr($index[0],'footer.php') ) {
        $template_file = $index[0] ;
      }
    }
  }
  $template_contents = file_get_contents($template_file) ;
  preg_match_all("(Template Name:(.*)\n)siU",$template_contents,$template_name);
  $template_name = trim($template_name[1][0]);
  if (!$template_name) { 
    $template_name = '(default)'; 
  }
  $template_file = array_pop(explode('/themes/', basename($template_file)));
  return $template_file . ' > '. $template_name ;
}



?>