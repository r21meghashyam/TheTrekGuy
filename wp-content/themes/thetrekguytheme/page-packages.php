<?php 
/*
Template Name: Packages
*/
  $GLOBALS[ 'page' ]="packages";
  get_header();
  
?>
  <a id="top" name="#top"></a>
  <div class="parallax" style="background-image:url('<?php
$upload_dir = wp_upload_dir();
 echo $upload_dir['baseurl'] ?>/2017/05/5.jpg')">
  <div class="cover-text"><h1>Make your holidays worthfull</h1></div>
</div>
   <div class="packages container">  
     <div class="row">
<?php
$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

if(!$con)
    die("Unable to connect to database.");

$r=mysqli_query($con,"CREATE TABLE IF NOT EXISTS ttg_packages(
        title varchar(100),
        image varchar(100),
        description varchar(1999),
        price varchar(100),
        date varchar(100)
       )");
if(mysqli_error($con))
   {
        die(mysqli_error($con));
   }

$package_table=mysqli_query($con,"select * from ttg_packages");
if(mysqli_error($con))
   {
        die(mysqli_error($con));
   }

if($package_table){
    
    
  while($r=mysqli_fetch_row($package_table)){
?>
<a href="#">
    <div class="package col-md-3" style="background-image:url('<?php echo $r[1];?>')">
      <div>
        <?php echo $r[0];?><br>
        <?php echo $r[3];?><br>
        </div>
    </div>
  </a>
    <?php
  }
}
?>
</div>
</div>
<?php 
$GLOBALS[ 'page' ]="packages";
get_footer();
?>
