<?php

/**
 * Define any (more generic) shortcodes here. The [gallery] shortcode 
 * is under media since it fits that category better.
 *  
 * @since 0.1
 * @file  wp.shortcodes.php
 */

function xs_site_shortcode($atts) {
   extract(shortcode_atts(array(
       'info' => '',
   ), $atts));

   $return = '';
   switch ($info) {
    case 'url':
        $return = SITE_URL;
        break;
    }
   return $return;
}

add_shortcode('site', 'xs_site_shortcode');

