<?php
// Register Custom Navigation Walker

require_once('plugin/wp-bootstrap-navwalker.php');

function ttg_theme_setup(){

    add_theme_support('post-thumbnails');
        
    register_nav_menus( array(
            'primary' => __( 'Primary Menu', 'THEMENAME' ),
    ) );

}

function new_excerpt_more($more) {
    global $post;
    return '...<span class="cr">Continue reading..</span>'; //Change to suit your needs
}
 
add_filter( 'excerpt_more', 'new_excerpt_more' );

add_action('after_setup_theme','ttg_theme_setup','100');


//Excerpt length controler

function set_excerpt_length(){
    return 12;
}

add_filter('excerpt_length',set_excerpt_length);


//Enclosing content apart of plugin contents
function filter_handler( $data , $postarr ) {
  $start='<div class=\"post-content\">';
   $len=strlen($start);
   
  if(strlen($data['post_content'])>$len&& substr(trim($data['post_content']),0,$len)!=$start){
      $data['post_content']=$start.$data['post_content']."</div>";
  }
  return $data;
}
add_filter( 'wp_insert_post_data', 'filter_handler', '99', 2 );


/** Step 2 (from text above). */
add_action( 'admin_menu', 'my_plugin_menu' );

/** Step 1. */
function my_plugin_menu() {
	add_menu_page( 'Packages Mannager for The Trek Guy', 'Packages', 'manage_options', 'package-settings', 'my_plugin_options' );
}

/** Step 3. */
function my_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	include('package-manager/index.php');
}
?>