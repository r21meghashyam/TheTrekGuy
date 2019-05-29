<?php 





function gv($f){
    $v=Array();
    $v['css/home.css']='a';
    $v['style.css']='1.0';
    return '?v='.$v[$f];
}
?>