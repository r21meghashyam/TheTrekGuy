<?php
/**
  * Share counter class
  * 
  */

class WPSR_Share_Counter{
    
    public static $default_settings = array(
        'counter_expiration' => 86400
    );
    
    public static function init(){
        
    }
    
    public static function counter_services(){
        
        return apply_filters( 'wpsr_mod_counter_services', array(
            'facebook' => array(
                'name' => 'Facebook',
                'callback' => array( __CLASS__, 'facebook_count' )
            ),
            'googleplus' => array(
                'name' => 'Google Plus',
                'callback' => array( __CLASS__, 'googleplus_count' )
            ),
            'linkedin' => array(
                'name' => 'Linked In',
                'callback' => array( __CLASS__, 'linkedin_count' )
            ),
            'pinterest' => array(
                'name' => 'Pinterest',
                'callback' => array( __CLASS__, 'pinterest_count' )
            ),
            'stumbleupon' => array(
                'name' => 'StumbleUpon',
                'callback' => array( __CLASS__, 'stumbleupon_count' )
            ),
        ));
        
    }
    
    public static function remote_request_json( $api_url, $method = 'get', $args = array() ){
        
        if( $method == 'get' ){
            $response = wp_remote_get( $api_url );
        }elseif( $method == 'post' ){
            $response = wp_remote_post( $api_url, $args );
        }else{
            return 0;
        }
        
        if( is_wp_error( $response ) ){
            return false;
        }else{
            if( $response[ 'response' ][ 'code' ] == 200 ){
                $data = json_decode( wp_remote_retrieve_body( $response ) );
                return $data;
            }else{
                return false;
            }
        }
    }
    
    public static function service_count( $id, $url ){
        
        $counter_services = self::counter_services();
        $gs = wp_parse_args( get_option( 'wpsr_general_settings' ), WPSR_Share_Counter::$default_settings );
        
        if( !array_key_exists( $id, $counter_services ) ){
            return 0;
        }
        
        $link_md5 = md5( $url );
        $transient_name = 'wpsr_count_' . $link_md5;
        $callback = $counter_services[ $id ][ 'callback' ];
        $expiration = $gs[ 'counter_expiration' ];
        
        $link_counts = get_transient( $transient_name );
        
        if( empty( $link_counts ) || !array_key_exists ( $id, $link_counts ) ){
            $count = call_user_func( $callback, $url );
            
            if( is_array( $link_counts ) ){
                $link_counts[ $id ] = $count;
            }else{
                $link_counts = array(
                    $id => $count
                );
            }
            
            set_transient( $transient_name, $link_counts, $expiration );
            return $count;
            
        }else{
            return $link_counts[ $id ];
        }
        
    }
    
    public static function get_count( $id, $url ){
        
        $count = self::service_count( $id, $url );
        $formatted = self::format_count( $count );
        
        return array(
            'full' => $count,
            'formatted' => $formatted
        );
        
    }
    
    public static function total_count( $url, $services = array() ){
        
        $counter_services = self::counter_services();
        $count = 0;
        
        foreach( $services as $id ){
            if( array_key_exists( $id, $counter_services ) ){
                $service_count = self::get_count( $id, $url );
                $count += $service_count[ 'full' ];
            }
        }
        
        $formatted = self::format_count( $count );
        
        return array(
            'full' => $count,
            'formatted' => $formatted
        );
        
    }
    
    public static function facebook_count( $url ){
        
        $api = 'https://graph.facebook.com/?id=' . $url;
        $data = self::remote_request_json( $api );
        
        if( $data == false ){
            return 0;
        }else{
            if( isset( $data->share->share_count ) ){
                return $data->share->share_count;
            }else{
                return 0;
            }
        }
        
    }
    
    public static function linkedin_count( $url ){
        
        $api = 'https://www.linkedin.com/countserv/count/share?format=json&url=' . $url;
        $data = self::remote_request_json( $api );
        
        if( $data == false ){
            return 0;
        }else{
            if( isset( $data->count ) ){
                return $data->count;
            }else{
                return 0;
            }
        }
        
    }
    
    public static function stumbleupon_count( $url ){
        
        $api = 'http://www.stumbleupon.com/services/1.01/badge.getinfo?url=' . $url;
        $data = self::remote_request_json( $api );
        
        if( $data == false ){
            return 0;
        }else{
            if( isset( $data->result->views ) ){
                return $data->result->views;
            }else{
                return 0;
            }
        }
        
    }
    
    public static function googleplus_count( $url ){
        
        $api = 'https://clients6.google.com/rpc';
        $data = self::remote_request_json( $api, 'post', array(
            'body' => '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $url . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]',
            'headers' => array("Content-type" => "application/json")
        ));
        
        if( $data == false ){
            return 0;
        }else{
            if( isset( $data[0]->result->metadata->globalCounts->count ) ){
                return $data[0]->result->metadata->globalCounts->count;
            }else{
                return 0;
            }
        }
        
    }
    
    public static function pinterest_count( $url ){
        
        $api = 'http://api.pinterest.com/v1/urls/count.json?callback=wpsr&url=' . $url;
        $response = wp_remote_get( $api );
        
        if( is_wp_error( $response ) ){
            return false;
        }else{
            if( $response[ 'response' ][ 'code' ] == 200 ){
                $data = self::jsonp_decode( wp_remote_retrieve_body( $response ) );
                
                if( isset( $data->count ) ){
                    return $data->count;
                }else{
                    return 0;
                }
                
            }else{
                return 0;
            }
        }
        
    }
    
    public static function format_count( $num ){
        
        if( $num < 1000 )
            return $num;
        
        $suffixes = array( 'k', 'm', 'b', 't' );
        $final = $num;

        for( $i=0; $i<sizeof($suffixes); $i++ ){
            $num = $num/1000;
            
            if( $num > 1000 ){
                continue;
            }else{
                $final = round( $num, 2 ) . $suffixes[$i];
                break;
            }
        }
        
        return $final;
    }
    
    public static function jsonp_decode( $jsonp ) { // PHP 5.3 adds depth as third parameter to json_decode
        if($jsonp[0] !== '[' && $jsonp[0] !== '{') { // we have JSONP
           $jsonp = substr($jsonp, strpos($jsonp, '('));
        }
        return json_decode( trim($jsonp,'();') );
    }
    
}