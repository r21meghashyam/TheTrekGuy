<?php
/**
  * LinkedIn service for WP Socializer
  *
  */

class wpsr_service_linkedin{
    
    function __construct(){
        
        WPSR_Services::register( 'linkedin', array(
            'name' => 'LinkedIn',
            'icons' => WPSR_ADMIN_URL . '/images/icons/linkedin.png',
            'desc' => __( 'Create LinkedIn buttons', 'wpsr' ),
            'settings' => array( 'size' => '500x200' ),
            'callbacks' => array(
                'output' => array( $this, 'output' ),
                'includes' => array( $this, 'includes' ),
                'settings' => array( $this, 'settings' ),
                'validation' => array( $this, 'validation' ),
                'general_settings' => array( $this, 'general_settings' ),
                'general_settings_validation' => array( $this, 'general_settings_validation' ),
            )
        ));
        
        $this->default_values = array(
            'type' => 'right'
        );
        
    }

    function output( $settings = array(), $page_info = array() ){
        
        $out = array();
        $settings = wp_parse_args( $settings, $this->default_values );
        
        $out['html'] = '<script type="IN/Share" data-url="' . esc_attr( $page_info[ 'url' ] ) . '" data-counter="' . esc_attr( $settings[ 'type' ] ) . '"></script>';
        $out['includes'] = array( 'linkedin_main_js' );
        return $out;
        
    }
    
    function includes(){
        
        $gs = wp_parse_args( get_option( 'wpsr_general_settings' ), WPSR_Lists::defaults( 'gsettings_linkedin' ) );
        $lang_code = $gs[ 'linkedin_lang' ];
        
        $includes = array(
            'linkedin_main_js' => array(
                'type' => 'js',
                'code' => '<script src="//platform.linkedin.com/in.js" type="text/javascript">lang: ' . $lang_code . '</script>'
            )
        );
        
        return $includes;
        
    }

    function settings( $values ){
        
        $values = wp_parse_args( $values, $this->default_values );
        
        $section1 = array(
            array( __( 'Counter position', 'wpsr' ), WPSR_Admin::field( 'select', array(
                'name' => 'o[type]',
                'value' => $values['type'],
                'list' => array(
                    'right' => __( 'Horizontal', 'wpsr' ),
                    'top' => __( 'Top', 'wpsr' ),
                    'none' => __( 'No count', 'wpsr' ),
                )
            ))),
        );

        WPSR_Admin::build_table( $section1, '', '', true);

    }

    function validation( $values ){
        
        return $values;
        
    }
    
    
    function general_settings( $values ){
        
        $values = wp_parse_args( $values, WPSR_Lists::defaults( 'gsettings_linkedin' ) );
        
        $section1 = array(
            array( __( 'LinkedIn language', 'wpsr' ), WPSR_Admin::field( 'select', array(
                'name' => 'linkedin_lang',
                'value' => $values['linkedin_lang'], 
                'list' => WPSR_Lists::lang_codes( 'linkedin' )
            ))),
        );

        WPSR_Admin::build_table( $section1, 'LinkedIn settings');
        
    }
    
    function general_settings_validation( $values ){
        return $values;
    }
    
}

new wpsr_service_linkedin();

?>