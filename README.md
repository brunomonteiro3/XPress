Xpress
------

Xpress is a starter theme for WordPress projects, with many tools ready to make development quicker. Base theme targets more dynamic, custom WordPress sites, less of a blog focus and more on custom WordPress development.


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
IS_LIVE // (boolean) Is site live?



?>
```

Functions
---------

All non Wordpress functions have been prefixed with x(?)_ to help make it identify custom functions. The exact prefix depends on the type of function. 

- x_ any function
- xf_ custom filter
- xa_ add custom action
- xs_ add shortcode

eg ```php <?php add_action( 'admin_menu', 'xa_update_menu' ); ?> ```


Template Functions
------------------


```php
<?php 

// Handles document <title>
x_doc_title(); 

// Works the same and handles the same parameters as wp_nav_menu(), but also caches menu
x_menu_cache( $args = array()); 

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
x_insert_attachment($fh, $post_id, $title, $to_thumb = false);

?>
```
