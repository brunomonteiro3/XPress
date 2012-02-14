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
SITE_URL (string) Site's URL
TMPL_URL (string) Template directory URL
DIR_TMPL (string) Path of template directory
DIR_CACHE (string) Path of cache directory
DIR_EXTND (string) Path of extensions (classes, includes, etc.)
URI (string) Current request
IS_MOBILE (boolean) Is browser mobile?

Functions
---------
the_doc_title() - Handles document <title>
menu_cache( $args = array()) - Works the same and handles the same parameters as wp_nav_menu(), but also caches menu
