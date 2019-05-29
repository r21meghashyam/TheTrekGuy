<?php 
/*
Template Name: Blog Posts
*/
  $GLOBALS[ 'page' ]="blog";
  get_header();
  query_posts('post_type=post&post_status=publish&posts_per_page=10&paged='. get_query_var('paged'));
?>
  <a id="top" name="#top"></a>
  
<div class="parallax" style="background-image:url('<?php
$upload_dir = wp_upload_dir();
 echo $upload_dir['baseurl'] ?>/2017/05/5.jpg')">
 <div class="cover-text"><h1>Tales</h1></div>
</div>  
<?php
  $i=0;
  while($i++<3&&have_posts()): the_post();?>
  <a href="<?php the_permalink();?>">
    <div class="parallax" style="background-image:url('<?php echo get_the_post_thumbnail_url() ?>');">
      <div class="cover-text">
      <h1><?php the_title();?></h1>
      <div><?php the_excerpt();?></div>
      </div>
    </div>
  </a>
<?php 
  endwhile;
?>

<?php 
$GLOBALS[ 'page' ]="blog";
get_footer();
?>
