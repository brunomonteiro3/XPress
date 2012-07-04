<?php get_header(); ?>
<!-- index.php -->
</section>
<section id="content-primary" class="page-width">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?> 
<?php echo '<time class="updated" datetime="'. get_the_time('c') .'" pubdate>'. sprintf(__('Posted on <span class="date">%s</span> at <span class="time">%s</span>'), get_the_date(), get_the_time()) .'</time>'; ?>
<div class="post-author" itemscope itemtype="http://schema.org/Person">
	<?php echo get_avatar( get_the_author_meta( 'user_email' ),60); ?>
	<h6 class="author-name" itemprop="name"><?php the_author(); ?></h4>
    <div class="author-bio"><?php the_author_meta('description'); ?></div>
    <a class="author-link" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">View Author Posts</a>                     
</div>

  <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
  <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
  <div class="index-entry">
    <?php the_content(); ?>
    <div class="navigation"><?php wp_link_pages();  ?> </div>
    <div class="clearfix"></div>
    	<div class="nav-previous">
    		<?php previous_post_link(); ?>
    	</div>
		<div class="nav-next">
			<?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'themename' ) . '</span>' ); ?>
		</div>
    <?php comments_template(); ?> 
    <?php edit_post_link('EDIT', '<p>', '</p>'); ?>
  </div>
</div>
<?php wp_link_pages(); ?>
<?php endwhile; ?>
 <?php else : ?>
<h2>Not Found</h2>
<?php endif; ?>
</section>
<!-- // index.php -->
<?php get_footer(); ?>
