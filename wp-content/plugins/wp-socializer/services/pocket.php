<?php
/**
  * Pocket service for WP Socializer
  *
  */

class wpsr_service_pocket{
    
    function __construct(){
        
        WPSR_Services::register( 'pocket', array(
            'name' => 'Pocket',
            'icons' => WPSR_ADMIN_URL . '/images/icons/pocket.png',
            'desc' => __( 'Create Pocket buttons', 'wpsr' ),
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
            'type' => 'horizontal',
        );
        
    }

    function output( $settings = array(), $page_info = array() ){
        
        $out = array();
        $settings = wp_parse_args( $settings, $this->default_values );
        $html = '';
        
        $html = '<a data-pocket-label="pocket" data-pocket-count="' . esc_attr( $settings[ 'type' ] ) . '" class="pocket-btn" data-save-url="' . esc_attr( $page_info[ 'url' ] ) . '" data-lang="en">Pocket</a>';
        $html .= '<script type="text/javascript">!function(d,i){if(!d.getElementById(i)){var j=d.createElement("script");j.id=i;j.src="https://widgets.getpocket.com/v1/j/btn.js?v=1";var w=d.getElementById(i);d.body.appendChild(j);}}(document,"pocket-btn-js");</script>';
        
        $out['html'] = $html;

        $out['includes'] = array();
        return $out;
        
    }
    
    function includes(){
        
        $includes = array();
        
        return $includes;
        
    }

    function settings( $values ){
        
        $values = wp_parse_args( $values, $this->default_values );
        
        $section1 = array(
            array( __( 'Button type', 'wpsr' ), WPSR_Admin::field( 'select', array(
                'name' => 'o[type]',
                'value' => $values['type'],
                'list' => array(
                    'horizontal' => 'Horizontal counter',
                    'vertical' => 'Vertical counter',
                    'none' => 'No counter',
                ),
            ))),
        );

        WPSR_Admin::build_table( $section1, '', '', true);
        
    }

    function validation( $values ){
        
        return $values;
        
    }
    
    function general_settings( $values ){
    
    }
    
    function general_settings_validation( $values ){
        return $values;
    }
    
}

new wpsr_service_pocket();

?>