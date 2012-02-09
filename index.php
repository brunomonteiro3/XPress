<?php get_header(); ?>
<!-- index.php -->
</section>
<section id="content-primary" class="container">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?> 
  <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
  <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
  <div class="index-entry">
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
<!-- // index.php -->
<?php get_footer(); ?>
