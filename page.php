<?php get_header(); ?>
<!-- page.php -->
</section>
<section id="content-primary" class="page-width">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?> 
 
  <h1><?php the_title(); ?></h2>
  <div class="page-content full-width" id="post-<?php the_ID(); ?>">
    <?php the_content(); ?>
    <div class="clearfix"></div>
    <?php edit_post_link('EDIT', '<p>', '</p>'); ?>
  </div>
</div>


<?php endwhile; ?>
 <?php else : ?>
<h2>Not Found</h2>
<?php endif; ?>
</section>
<!-- // page.php -->
<?php get_footer(); ?>
