<?php 
  /*
  Template Name: Front Page
  Template Post Type: front-page
  */

  /*Passing page status to header.php */
  $GLOBALS[ 'page' ]="front";

  /* Getting header content */
  get_header();
?>
<a id="top" name="#top"></a>

<div class="parallax" style="background-image:url('<?php
$upload_dir = wp_upload_dir();
 echo $upload_dir['baseurl'] ?>/2017/05/5.jpg')">
</div>


<?php 
  if(have_posts()):
 /*
<!--BLOG_BEGIN-->
*/?>
<div class=" blog-container">
  <div class="container">
    <div class="divliner">
      <h2>Traveler's Tales</h2>
    </div>
    <div class="row"><?php //row-begin?>
      <?php 
        $i=0;
        while($i++<3&&have_posts()): the_post();
      ?>
      <a href="<?php the_permalink();?>">
        <div class="col-md-4 post">
          <div class="zoom-image">
            <?php 
              if(has_post_thumbnail())
                the_post_thumbnail();
              else
                {
            ?>
                <img src="<?php bloginfo('template_url'); ?>/media/2.jpg">
            <?php 
                }
            ?>
          </div>
          <div class="blog-text">
            <h4><?php the_title();?></h4>
            <p><?php the_excerpt();?></p>
          </div>
        </div>
      </a>
      <?php 
        endwhile; 
      ?>
    </div><?php //row-end?>
  </div><?php //container-end?>
</div>
<?php /*
<!--BLOG_END-->
*/?>
<?php 
  endif;
?>

<div class="parallax" style="background-image:url('<?php echo $upload_dir['baseurl'] ?>/2017/05/6.jpg')"></div>
   
<!-- Packages -->
<div class=" package-container bg-dark">
  <div class="container">
    <div class="divliner">
      <h2>Destinations</h2>
    </div>
    <div class="" style="text-align:center;padding:20px;">
    Contact us to conduct personalised treks only for you, your family and friends at an affordable price.<br><br>

    Select from our featured destinations:<br>                        
    1. Kumara Parvatha<br>
2. Kodachadri<br>
3. Ettina bhuja<br>
4. Tadiandamol     <br>                   
Or if u have any location in your mind      <br>                  
Do let us know
<br>
<div style="font-size:20px;">
Call Now:<br>
<i class="fa fa-phone" aria-hidden="true"></i> +91 7760844375<br>
Or<br>
<a href="mailto:yshakjp@gmail.com" style="color:#FFF;text-decoration:none;"><i class="fa fa-envelope-o" aria-hidden="true"></i> yshakjp@gmail.com</a>
</div>

    </div>
  </div>
     <!-- /Packages-->
    

</div>
<script src="//www.powr.io/powr.js" external-type="html"></script> 
 <div class="powr-instagram-feed" id="c3f66ab0_1496233190"></div>
 <div class="hider"></div>
<?php 
$GLOBALS[ 'page' ]="front";
get_footer();
?>
