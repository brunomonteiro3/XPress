<?php if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ){
}  ?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?php the_doc_title(); ?></title>

  <link rel="stylesheet" href="<?php echo TMPL_URL; ?>/site.css">
  <link rel="stylesheet" href="<?php echo TMPL_URL; ?>/css/prettyPhoto.css">
  <script src="<?php echo TMPL_URL; ?>/js/libs/modernizr-2.0.6.min.js"></script>
  
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<section id="content-heading">
  <header id="pre-header" class="dark">
    <div class="page-width">
      
    </div>
  </header>
  <div class="page-width">
    <header id="header">
      <a id="go-home" href="<?php echo SITE_URL; ?>"></a>
      <?php 
        
        $args = array(
            'menu'          =>'Menu - Main' , 
            'container'     => '',
            'menu_id'       => 'menu-main',
            'fallback_cb'   => 'wp_page_menu'
        );
        // For more dynamics sites, that don't use a caching plugin
        menu_cache($args); 
        // If the site will be using a caching plugin
        // wp_nav_menu( $args );
     ?>
</header>

