Custom WP Theme Base
--------------------

Starter theme for WordPress projects, with much of my functions.php tools ready to make development quicker. Base theme targets more dynamic, custom WordPress sites, less of a blog focus and more on custom web development.


Features
--------
- Constants for commonly accessed variables & functions
- Has LESSphp baked in
- Custom redirects after user login
- Cleans up wp_head()
- Remove menu items (remove comments, links, or whatever you don't want)
- Mobile device detection & mobile template loader
- Setup for Admin dashboard and login logos
- Custom menu output
- Menu caching
- Enhanced Search (highlight terms and show result count)


Constants
---------
```php
<?php 

SITE_URL // (string) Site's URL -  same as get_bloginfo('url')
WP_URL // (strong) Access WordPress URL - same as get_bloginfo('wpurl')
TMPL_URL // (string) Template directory URL - get_bloginfo('template_url')
DIR_TMPL // (string) Path of template directory
DIR_CACHE // (string) Path of cache directory
DIR_EXTND // (string) Path of extensions (classes, includes, etc.)
DIR_ADMIN // // (string) Path of WordPress wp-admin folder
URI // (string) Current request
IS_MOBILE // (boolean) Is browser mobile?

?>
```
Template Functions
------------------
```php
<?php 

// Handles document <title>
the_doc_title(); 

// Works the same and handles the same parameters as wp_nav_menu(), but also caches menu
menu_cache( $args = array()); 

/*

$fh - File Handler $_FILE
$post_id - ID of parent post
$title - title Of images
$to_thumb - make it parent post thumnail?

@usage
if ($_FILES['thumbnail']){
  insert_attachment($_FILES['thumbnail'],$ID, $_POST['post']['post_title'], true);
}

*/
insert_attachment($fh, $post_id, $title, $to_thumb = false);

?>
```
