<!DOCTYPE html>
<html <?php language_attributes();?>>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <link rel="icon" href="../../favicon.ico">
    <title><?php 
    include('cache-control.php');
    if($GLOBALS['page']=="404")
      echo "Page Not Found";
    else
      bloginfo('name');wp_title();
    ?></title>
    <meta name="template_url" value="<?php bloginfo('template_url'); ?>">
    <link href="<?php bloginfo('template_url'); ?>/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Bree+Serif" rel="stylesheet">    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php if($GLOBALS['page']=="front"):?>
    <link href="<?php bloginfo('template_url'); ?>/css/home.css<?php echo gv('css/home.css'); ?>" rel="stylesheet">
    <?php endif;?>
    <?php if($GLOBALS['page']=="packages"):?>
    <link href="<?php bloginfo('template_url'); ?>/css/packages.css" rel="stylesheet">
    <?php endif;?>
    <?php if($GLOBALS['page']=="blog"):?>
    <link href="<?php bloginfo('template_url'); ?>/css/blog.css" rel="stylesheet">
    <?php endif;?>
    <?php if($GLOBALS['page']=="post"):?>
    <link href="<?php bloginfo('template_url'); ?>/css/post.css" rel="stylesheet">
    <link href="<?php bloginfo('template_url'); ?>/css/image-viewer.css" rel="stylesheet">
    <?php endif;?>
    <link href="<?php bloginfo('stylesheet_url');  echo gv('css/home.css'); ?>" rel="stylesheet">
    <?php wp_head();?>
  </head>
<!-- NAVBAR
================================================== -->
  <body>
    <div id="wptime-plugin-preloader"></div>
      <nav class="navbar  navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="/">
               
                   <img src="<?php bloginfo('template_url'); ?>/media/logo.png" class="logo">
               
              </a>
            </div>
            <?php
            wp_nav_menu( array(
                'menu'              => 'primary',
                'theme_location'    => 'primary',
                'depth'             => 2,
                'container'         => 'div',
                'container_class'   => 'navbar-collapse collapse',
                'container_id'      => 'navbar',
                'menu_class'        => 'nav navbar-nav navbar-right',
                'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                'walker'            => new WP_Bootstrap_Navwalker())
            );
            ?>
        </div>
     </nav>