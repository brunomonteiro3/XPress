<?php
/*
Template Name: Page - Sidebar
*/
?>
<?php get_header(); ?>
<!-- page.php -->
</section>
<section id="content-primary" class="page-width">

<h1><?php the_title(); ?></h1>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?> 
<div class="page-content col-third-2" id="post-<?php the_ID(); ?>">
    <?php the_content(); ?>
    <div class="clearfix"></div>
   
  </div>
</div>
<?php get_sidebar(); ?>
<?php edit_post_link('EDIT', '<p>', '</p>'); ?>
<div class="clearfix"></div>


<?php endwhile; ?>
 <?php else : ?>
<h2>Not Found</h2>
<?php endif; ?>
</section>
<!-- // page.php -->
<?php get_footer(); ?>
