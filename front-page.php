<?php get_header(); ?>
<!-- front-page.php -->
	<section id="current-germ">

	</section>
</section>
<section id="content-front-page" class="page-width">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<article class="blog-post">
      	<h2><?php the_title(); ?></h2>
	 	<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
	</article>
<?php endwhile; endif; ?>
<?php edit_post_link('EDIT', '', ''); ?>


</section>
<!-- // front-page.php -->
<?php get_footer(); ?>
