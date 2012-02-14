<?php get_header(); ?>
<!-- search.php -->
</section>
<section id="content-primary" class="page-width">
<section id="search-page">
<?php 
	global $wp_query;
	$total_results = $wp_query->found_posts;

	$query = get_search_query();
	$terms = explode(" ",$query);  	

?>

<h1>Search Results</h1>
<div id="search-count"><?php echo $total_results; ?></div>
<div id="search-query"><?php echo $query; ?></div>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?> 
  <?php echo search_hilighter(get_the_title(), $terms); ?>
  <div class="page-content full-width" id="post-<?php the_ID(); ?>">
    <?php search_hilighter(get_the_excerpt(), $terms); ?>
 <div class="clearfix"></div>
    <?php edit_post_link('EDIT', '<p>', '</p>'); ?>
  </div>
</div>


<?php endwhile; ?>
 <?php else : ?>
<h2>Not Found</h2>
<?php endif; ?>
</section>
</section>
<!-- // search.php -->
<?php get_footer(); ?>
