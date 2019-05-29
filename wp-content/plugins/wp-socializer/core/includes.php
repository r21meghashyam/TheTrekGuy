<?php
/**
  * Controls the script and styles to be printed on page
  * 
  */

class WPSR_Includes{
    
    private static $all_includes = array();
    private static $active_includes = array();
    
    public static function init(){
        
        // The default includes for template
        self::register( array(
            'main_css' => array(
                'type' => 'css',
                'link' => WPSR_URL . 'public/css/wp-socializer.min.css',
                'deps' => array()
            ),
            
            'main_js' => array(
                'type' => 'js',
                'link' => WPSR_URL . 'public/js/wp-socializer.min.js',
                'deps' => array()
            )
            
        ));
        
        self::add_active_includes( array( 'main_css', 'main_js' ) );
        
        // Print CSS in header
        add_action( 'wp_enqueue_scripts' , array( __CLASS__, 'print_styles' ) );
        
        // Print scripts in footer
        add_action( 'wp_footer', array( __CLASS__, 'print_scripts' ) );
        
    }
    
    public static function register( $includes ){
        
        if( is_array( $includes ) ){
            foreach( $includes as $inc_id => $inc_info ){
                if( !array_key_exists( $inc_id, self::$all_includes ) ){
                    
                    self::$all_includes[ $inc_id ] = $inc_info;
                    
                }
            }
        }
        
    }
    
    public static function do_wp_register(){
        
        $includes = self::list_all();
        
        foreach( $includes as $inc_id => $inc_info ){
            
            $deps = array();
            if( isset( $inc_info[ 'deps' ] ) ){
                $deps = $inc_info[ 'deps' ];
            }
            
            if( $inc_info[ 'type' ] == 'js' ){
                if( isset( $inc_info[ 'link' ] ) ){
                    wp_register_script( 'wpsr_' . $inc_id, $inc_info[ 'link' ], $deps );
                }
            }elseif( $inc_info[ 'type' ] == 'css' ){
                if( isset( $inc_info[ 'link' ] ) ){
                    wp_register_style( 'wpsr_' . $inc_id, $inc_info[ 'link' ], $deps );
                }
            }
            
        }
    }
    
    public static function list_all(){
        
        return apply_filters( 'wpsr_mod_includes_list', self::$all_includes );
        
    }
    
    public static function add_active_includes( $include_ids ){
        
        $includes = self::list_all();
        
        foreach( $include_ids as $inc_id ){
            if( array_key_exists( $inc_id, $includes ) && !in_array( $inc_id, self::$active_includes ) ){
                array_push( self::$active_includes, $inc_id );
            }
        }
        
    }
    
    public static function active_includes(){
        
        return apply_filters( 'wpsr_mod_includes_active', self::$active_includes );
        
    }
    
    public static function print_scripts(){
        
        $includes = self::list_all();
        $active_includes = self::active_includes();
        
        echo "\n<!-- WP Socializer " . WPSR_VERSION . " - JS - Start -->\n";
        foreach( $active_includes as $a_inc ){
            if( array_key_exists( $a_inc, $includes ) ){
                $inc_info = $includes[ $a_inc ];
                if( $inc_info[ 'type' ] == 'js' ){
                    
                    if( array_key_exists( 'link', $inc_info ) ){
                        wp_enqueue_script( 'wpsr_' . $a_inc );
                    }elseif( array_key_exists( 'code', $inc_info ) ){
                        
                        if( isset( $inc_info[ 'deps' ] ) ){
                            foreach( $inc_info[ 'deps' ] as $dep_handle ){
                                wp_enqueue_script( $inc_info[ 'deps' ] );
                            }
                        }
                        
                        echo $inc_info[ 'code' ];
                    }
                    
                }
            }
        }
        echo "\n<!-- WP Socializer - JS - End -->\n";
        
        $gs = get_option( 'wpsr_general_settings' );
        $gs = wp_parse_args( $gs, WPSR_Lists::defaults( 'gsettings_misc' ) );
        
        if( trim( $gs[ 'misc_additional_css' ] ) != '' ){
            echo "<!-- WP Socializer - Custom CSS rules - Start --><style>" . $gs[ 'misc_additional_css' ] . "</style><!-- WP Socializer - Custom CSS rules - End -->\n";
        }
        
    }
    
    public static function print_styles(){
        
        // Forcefully include all CSS includes
        $includes = self::list_all();
        
        // Register all the includes including JS and CSS
        self::do_wp_register();
        
        foreach( $includes as $inc_id => $inc_info ){
            
            if( $inc_info[ 'type' ] == 'css' ){
                
                if( isset( $inc_info[ 'link' ] ) ){
                    wp_enqueue_style( 'wpsr_' . $inc_id );
                }
                
                if( isset( $inc_info[ 'code' ] ) ){
                    echo '<style type="text/css">' . wp_strip_all_tags( $inc_info[ 'code' ] ) . '</style>';
                }
                
            }
        }
        
    }
    
    public static function preview_print_includes(){
        
        $includes = self::list_all();
        $active_includes = self::active_includes();
        
        // Include all CSS forcefully
        foreach( $includes as $inc_id => $inc_info ){
            
            if( $inc_info[ 'type' ] == 'css' ){
                
                if( isset( $inc_info[ 'link' ] ) ){
                    echo '<link rel="stylesheet" id="' . $inc_id . '" href="'  . $inc_info[ 'link' ] . '" type="text/css"/>'. "\n";
                }
                
                if( isset( $inc_info[ 'code' ] ) ){
                    echo '<style type="text/css">' . wp_strip_all_tags( $inc_info[ 'code' ] ) . '</style>';
                }
                
            }
        }
        
        foreach( $active_includes as $a_inc ){
            if( array_key_exists( $a_inc, $includes ) ){
                $inc_info = $includes[ $a_inc ];
                if( $inc_info[ 'type' ] == 'js' ){

                    if( array_key_exists( 'link', $inc_info ) ){
                        echo '<script src="' . $inc_info[ 'link' ] . '"></script>' . "\n";
                    }elseif( array_key_exists( 'code', $inc_info ) ){
                        echo $inc_info[ 'code' ];
                    }
                    
                }
            }
        }
        
    }
    
}

WPSR_Includes::init();

?>