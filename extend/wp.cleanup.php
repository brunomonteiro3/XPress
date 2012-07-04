<?php

/**
 * Cleanup extra WordPress 'ish I don't want
 * 
 *  
 * @since 0.1
 * @file  wp.cleanup.php
 */

// Kill the admin bar
// show_admin_bar(false);

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
function xa_disable_feed() {
  wp_die(__('<h1>Feed not available, please visit our <a href="'.get_bloginfo('url').'">Home Page</a>!</h1>'));
}

add_action('do_feed',      'xa_disable_feed', 1);
add_action('do_feed_rdf',  'xa_disable_feed', 1);
add_action('do_feed_rss',  'xa_disable_feed', 1);
add_action('do_feed_rss2', 'xa_disable_feed', 1);
add_action('do_feed_atom', 'xa_disable_feed', 1);


// Remove Comments and Links manager
add_action( 'admin_menu', 'xa_update_menu' );

function xa_update_menu() {
  // remove_menu_page('link-manager.php');
  // remove_menu_page('themes.php');
  // remove_menu_page('plugins.php');
  // remove_menu_page('edit-comments.php');
}


// Kill dashboard widgets
add_action('wp_dashboard_setup', 'xa_dashboard_widgets');

function xa_dashboard_widgets() {
  global $wp_meta_boxes;
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
}




