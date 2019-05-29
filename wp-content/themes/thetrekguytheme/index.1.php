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
    <!-- Carousel BEGIN-->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <?php
$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);



$r=mysqli_query($con,"CREATE TABLE IF NOT EXISTS ttg_packages(
        title varchar(100),
        image varchar(100),
        description varchar(1999),
        price varchar(100),
        date varchar(100)
       )");


$package_table=mysqli_query($con,"select * from ttg_packages");


if($package_table){
    
    $package=Array();
  while($r=mysqli_fetch_row($package_table)){
    array_push($package,Array("title"=>$r[0],"image"=>$r[1],"description"=>$r[2],"price"=>$r[3],"date"=>$r[4],"id"=>$r[5]));
  }
}
?>
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <?php
        $i=0;
        for($i=0;$i<count($package);$i++){
          $class = $i==0?"active":"";
        echo '<li data-target="#myCarousel" data-slide-to="'.$i.'" class="'.$class.'"></li>';
        }

        ?>
      </ol>

      <div class="carousel-inner" role="listbox">
        <?php 
        for($i=0;$i<count($package);$i++){
           $class = $i==0?"item active":"item";
        ?>
        <div class="<?php echo $class;?>">
          <div class="row package-info">
            <div class="col-md-6">
              <img src="<?php echo $package[$i]["image"]; ?>">
            </div><?PHP //col-md-6?>
            <div class="col-md-6">
              <h1><?php echo $package[$i]["title"]; ?></h1>
              <div><?php echo $package[$i]["description"]; ?></div>
              <div><?php echo $package[$i]["date"]; ?> | <?php echo $package[$i]["price"]; ?> </div>
              <div class="buttons" >
                <a href="/package-details?id=<?php echo $package[$i]["id"];?>">View Details</a>
              </div>
            </div><?php //col-md-6 ?>
          </div><?php //row package-info ?>
        </div><?php //item active 
        }

        ?>

        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
    
    </div>
  </div>
  </div>
     <!-- /Packages-->
    

</div>

<?php 
$GLOBALS[ 'page' ]="front";
get_footer();
?>
