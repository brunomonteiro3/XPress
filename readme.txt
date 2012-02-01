
Add to wp-config.pgp
# Maximum 5 revisions #
define('WP_POST_REVISIONS', 5);
# Disable revisions #
define('WP_POST_REVISIONS', false);


THE TEMPLATE HIERARCHY IN DETAIL
The following sections describe the order in which template files are being called by WordPress for each query type.

Home Page display
1 home.php
2 index.php 

Front Page display
1 front-page.php - Used for both Your latest posts or A static page as set in the Front page displays section of Settings -> Reading
2 Page display rules - When Front page is set in the Front page displays section of Settings -> Reading
3 Home Page display rules - When Posts page is set in the Front page displays section of Settings -> Reading 

Single Post display
1 single-{post_type}.php - If the post type were product, WordPress would look for single-product.php.
2 single.php
3 index.php 

Page display
1 custom template file - The Page Template assigned to the Page. See get_page_templates().
2 page-{slug}.php - If the page slug is recent-news, WordPress will look to use page-recent-news.php
3 page-{id}.php - If the page ID is 6, WordPress will look to use page-6.php
4 page.php
5 index.php 

Category display
1 category-{slug}.php - If the category's slug were news, WordPress would look for category-news.php
2 category-{id}.php - If the category's ID were 6, WordPress would look for category-6.php
3 category.php
4 archive.php
5 index.php 

Tag display
1 tag-{slug}.php - If the tag's slug were sometag, WordPress would look for tag-sometag.php
2 tag-{id}.php - If the tag's ID were 6, WordPress would look for tag-6.php
3 tag.php
4 archive.php
5 index.php 

Custom Taxonomies display
1 taxonomy-{taxonomy}-{slug}.php - If the taxonomy were sometax, and taxonomy's slug were someterm WordPress would look for taxonomy-sometax-someterm.php. In the case of Post Formats, the taxonomy is 'post_format' and the terms are 'post-format-{format}. i.e. taxonomy-post_format-post-format-link.php
2 taxonomy-{taxonomy}.php - If the taxonomy were sometax, WordPress would look for taxonomy-sometax.php
3 taxonomy.php
4 archive.php
5 index.php 

Custom Post Types display
1 archive-{post_type}.php - If the post type were product, WordPress would look for archive-product.php.
2 archive.php
3 index.php 

(when displaying a single custom post type see the Single Post display section above.)
Author display
1 author-{nicename}.php - If the author's nice name were rami, WordPress would look for author-rami.php.
2 author-{id}.php - If the author's ID were 6, WordPress would look for author-6.php.
3 author.php
4 archive.php
5 index.php 

Date display
1 date.php
2 archive.php
3 index.php 

Search Result display
1 search.php
2 index.php 

404 (Not Found) display
1 404.php
2 index.php 

Attachment display
1 MIME_type.php - it can be any MIME type (image.php, video.php, application.php). For text/plain, in order:
 - text.php
 - plain.php
 - text_plain.php 
2 attachment.php
3 single-attachment.php
4 single.php
5 index.php 

Filter Hierarchy

The WordPress templates system allow you to filter the hierarchy. The filter (located in the get_query_template() function) uses this filter name: "{$type}_template" where $type is the a file name in the hierarchy without the .php extension.

Full list:

- index_template
- 404_template
- archive_template
- author_template
- category_template
- tag_template
- taxonomy_template
- date_template
- home_template
- front_page_template
- page_template
- paged_template
- search_template
- single_template
- text_template, plain_template, text_plain_template (all mime types)
- attachment_template
- comments_popup 
