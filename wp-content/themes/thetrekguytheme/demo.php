<?php
function go( $data ) {
  $start='<div class="post-content">';
   $len=strlen($start);
  if(strlen($data)>$len&& substr(trim($data),0,$len)!=$start){
      $data=$start.$data."</div>";
  }
  return $data;
}
echo go('<div class="post-content">Hello World this is and apple in the forest</div>');
?>