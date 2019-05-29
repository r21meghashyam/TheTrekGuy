<?php
/**
  * General settings admin page
  *
  **/
  
class wpsr_admin_settings{
    
    function __construct(){
        
        WPSR_Admin::add_tab( 'general_settings', array(
            'name' => 'Settings',
            'page_callback' => array( $this, 'page' ),
            'form' => array(
                'id' => 'general_settings',
                'name' => 'general_settings',
                'callback' => ''
            )
        ));
        
        add_action( 'wpsr_form_general_settings', array( $this, 'misc_general_settings' ), 10, 1 );
        
    }
    
    function page(){
        
        WPSR_Admin::settings_form( 'general_settings' );
    }
    
    function validation( $input ){
        return $input;
    }
    
    function misc_general_settings( $values ){
        
        $values = wp_parse_args( $values, WPSR_Lists::defaults( 'gsettings_misc' ) );
        
        $section1 = array(
            array( __( 'Additional CSS rules', 'wpsr' ), WPSR_Admin::field( 'textarea', array(
                'name' => 'misc_additional_css',
                'value' => $values['misc_additional_css'],
                'helper' => __( 'Enter custom CSS rules to customize without the style tag', 'wpsr' ),
                'rows' => '3',
                'cols' => '100'
            )))
        );

        WPSR_Admin::build_table( $section1, __( 'Miscellaneous settings', 'wpsr' ) );
    }
    
}

new wpsr_admin_settings();

?>