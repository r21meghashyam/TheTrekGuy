<?php 
$GLOBALS[ 'page' ]="404";
get_header();?>
   
    <a id="top" name="#top"></a>
    
 <div class="parallax" style="background-image:url('<?php
$upload_dir = wp_upload_dir();
 echo $upload_dir['baseurl'] ?>/2017/05/5.jpg')"> <div class="cover-text"><h1>OOPS! 404 | Page Not Found</h1></div>
   </div>

<?php 
$GLOBALS[ 'page' ]="404";
get_footer();
?>
