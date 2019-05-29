<?php 

    //Core media script
    wp_enqueue_media();

$id=!empty($_GET["package-id"])?$_GET["package-id"]:die("Please enter package id");

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


$package=mysqli_query($con,"select * from ttg_packages where id=$id");
if(mysqli_error($con))
   {
        die(mysqli_error($con));
   }

if($package):
    $r=mysqli_fetch_row($package);
if($r){
?>
<div>
<style>
.package-table{

}
.package-table th{
  text-align:left;
  vertical-align:top;
}
.package-table textarea{
  width:800px;
}
img {
  max-width:500px;
  max-height:500px;
}
</style>
<form action="/wp-admin/admin.php?page=package-settings&ttg-page=demo.php" method="post">
<input type="hidden" name="package-id" value="<?php echo $id;?>">
<table class="package-table">
<tr><th>Title:</th><th> <input name="title" value="<?php echo $r[0];?>"></th></tr>
<tr><th>Descrption:</th><th> <textarea name="description" ><?php echo $r[2];?></textarea></th></tr>
<tr><th>Price(Rs.):</th><th> <input  name="price" value="<?php echo $r[3];?>"></th></tr>
<tr><th>Date:</th><th> <input name="date" value="<?php echo $r[4];?>"></th></tr>
<tr><th>Images:</th><th> <input id="image-url" type="hidden" name="image" value="<?php echo $r[1];?>"/><input id="upload-button" type="button" class="button" value="Upload Image" /><br>
    <img src="<?php echo $r[1];?>" id="image-url-view">
</th></tr>
</table>
<button>Submit</button>
</form>
</div>
<?php 
}
else
 echo "Package does not exists";
 endif;
?>
<a href="?page=package-settings"><button>Go Back</button></a>
<script>
  jQuery(document).ready(function($){

  var mediaUploader;

  $('#upload-button').click(function(e) {
    e.preventDefault();
    // If the uploader object has already been created, reopen the dialog
      if (mediaUploader) {
      mediaUploader.open();
      return;
    }
    // Extend the wp.media object
    mediaUploader = wp.media.frames.file_frame = wp.media({
      title: 'Choose Image',
      button: {
      text: 'Choose Image'
    }, multiple: false });

    // When a file is selected, grab the URL and set it as the text field's value
    mediaUploader.on('select', function() {
      attachment = mediaUploader.state().get('selection').first().toJSON();
      $('#image-url').val(attachment.url);
      $('#image-url-view').attr('src',attachment.url);
    });
    // Open the uploader dialog
    mediaUploader.open();
  });

});
</script>
