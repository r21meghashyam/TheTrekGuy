<?php
/**
  * Main API class for WP Socializer plugin
  * 
  */

class WPSR_Services{
    
    private static $services = array();
    private static $active_services = array();
    
    public static function init(){
        // Nothing to Init
    }
    
    public static function register( $id, $details ){
        
        $defaults = array(
            'name' => '',
            'icons' => '',
            'desc' => '',
            'settings' => array(),
            'hide_in_feature' => array(),
            'callbacks' => array(
                'output' => '',
                'includes' => '',
                'settings' => '',
                'validation' => '',
                'general_settings' => '',
                'general_settings_validation' => '',
            )
        );
        
        $details[ 'callbacks' ] = wp_parse_args( $details[ 'callbacks' ], $defaults[ 'callbacks' ] );
        $details = wp_parse_args( $details, $defaults );
        
        // Apply filter on the service config
        $details = apply_filters( 'wpsr_mod_service_config', $details );
        
        self::$services[ $id ] = $details;
        
        // Filters
        if( $details[ 'callbacks' ][ 'validation' ] != '' ){
            add_filter( 'wpsr_service_validation_' . $id, $details[ 'callbacks' ][ 'validation' ], 10, 1 );
        }
        
        if( $details[ 'callbacks' ][ 'general_settings' ] != '' ){
            add_action( 'wpsr_form_general_settings', $details[ 'callbacks' ][ 'general_settings' ], 10, 1 );
            add_filter( 'wpsr_form_validation_general_settings', $details[ 'callbacks' ][ 'general_settings_validation' ], 10, 1 );
        }
        
        self::register_includes( $id );
        
        do_action( 'wpsr_do_service_register' );
        
    }
    
    public static function list_all(){
        
        $services_temp = self::$services;
        
        foreach( $services_temp as $id => $config ){
            unset( $services_temp[ $id ][ 'callbacks' ] );
        }
        
        return apply_filters( 'wpsr_mod_services_list', $services_temp );
        
    }
    
    public static function output( $id, $settings = array(), $page_info = array() ){
        
        if( !self::check_callable( $id, 'output' ) ){
            return '';
        }
        
        return call_user_func( self::$services[ $id ][ 'callbacks' ][ 'output' ], $settings, $page_info );
        
    }
    
    public static function settings( $id, $values ){
        
        if( !self::check_callable( $id, 'settings' ) ){
            return '';
        }
        
        return call_user_func( self::$services[ $id ][ 'callbacks' ][ 'settings' ], $values );
        
    }
    
    public static function register_includes( $id ){
        
        if( !self::check_callable( $id, 'includes' ) ){
            return '';
        }
        
        $service_includes = call_user_func( self::$services[ $id ][ 'callbacks' ][ 'includes' ] );
        
        WPSR_Includes::register( $service_includes );
    }
    
    public static function check_callable( $id, $callback ){
        
        $services = self::$services;
        
        if( array_key_exists( $id, $services ) ){
            $service = $services[ $id ];
            if( array_key_exists( $callback, $service[ 'callbacks' ] ) && !empty( $service[ 'callbacks' ][ $callback ] ) && is_callable( $service[ 'callbacks' ][ $callback ] ) ){
                return 1;
            }
        }
        
        return 0;
        
    }
    
    public static function add_active_service( $id ){
        
        $services_active = self::$active_services;
        
        if( !empty( $id ) && !in_array( $id, self::$active_services ) ){
            array_push( self::$active_services, $id );
        }
        
    }
    
    public static function active_services(){
        
        return apply_filters( 'wpsr_mod_active_services_list', self::$active_services );
        
    }
}

WPSR_Services::init();

?>