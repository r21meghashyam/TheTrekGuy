<?php 

    //Core media script
    wp_enqueue_media();

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
<form action="/wp-admin/admin.php?page=package-settings&ttg-page=insert.php" method="post">


<table class="package-table">
<tr><th>Title:</th><th> <input name="title"></th></tr>

<tr><th>Descrption:</th><th> <textarea name="description"></textarea></th></tr>
<tr><th>Price:</th><th> <input  name="price" value="Rs. "></th></tr>
<tr><th>Date:</th><th> <input name="date"></th></tr>
<tr><th>Images:</th><th> <input id="image-url" type="hidden" name="image" /><input id="upload-button" type="button" class="button" value="Upload Image" /><br>
    <img src="" id="image-url-view">
</th></tr>

</table>
<button>Submit</button>
</form>
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
<?php

?>
<a href="?page=package-settings"><button>Go Back</button></a>
</div>