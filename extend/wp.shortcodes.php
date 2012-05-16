<?php

function site_shortcode($atts) {
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

add_shortcode('site', 'site_shortcode');

