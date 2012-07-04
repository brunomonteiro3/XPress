<footer id="footer">
  <div class="page-width">
  <?php $args = array(
          'menu'          => 'Menu - Footer',
          'menu_id'       => 'menu-footer', 
          'container'     => 'nav',
          'container_id'  => 'menu-footer'
        );

        x_menu_cache($args); 
        // If the site will be using a caching plugin
        // wp_nav_menu( $args );
     
  ?>
  </div>
</footer>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="<?php echo TMPL_URL; ?>/js/libs/jquery-1.6.4.min.js"><\/script>')</script>
  <script defer src="<?php echo TMPL_URL; ?>/js/jquery.prettyPhoto.js"></script> 
  <script defer src="<?php echo TMPL_URL; ?>/js/app.js"></script> 
  <?php wp_footer(); ?>
  <script> 
    window._gaq = [['_setAccount','UAXXXXXXXX1'],['_trackPageview'],['_trackPageLoadTime']];
    Modernizr.load({
      load: ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js'
    });
  </script>
  <!--[if lt IE 8 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
</body>
</html>