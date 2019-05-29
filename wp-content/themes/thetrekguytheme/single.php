<?php
/*
Template Name: Blog 
Template Post Type: post
*/
  $GLOBALS['page']='post';
    get_header();
    the_post();?>
    <!-- Blog -->
    <a id="top" name="#top"></a>
 <div class="parallax" style="background-image:url('<?php echo get_the_post_thumbnail_url() ?>');"></div>
  <div class="container blog-container">
    <h2><?php the_title();?></h2>
    <div class="row">
     
   
      <div class="col-md-8 post">
       <?php 
            the_content();
            
       ?>
      </div>
      
     
     
      
    </div>
  </div>
     <!-- /Blog -->
    

     
<?php 
$GLOBALS[ 'page' ]="post";
get_footer();
?>
