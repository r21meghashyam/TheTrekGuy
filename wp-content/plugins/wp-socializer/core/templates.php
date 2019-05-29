<?php
/**
  * Templates processor
  * 
  */

class WPSR_Template_Buttons{
    
    public static function init(){
        
        add_action( 'init', array( __CLASS__, 'output' ) );
        
        add_action( 'wp_ajax_wpsr_preview_template_buttons', array( __CLASS__, 'preview' ) );
        
    }
    
    public static function output(){
        
        $btn_settings = wp_parse_args( get_option( 'wpsr_button_settings' ), array( 'tmpl' => array() ));
        $btn_templates = $btn_settings[ 'tmpl' ];
        
        foreach( $btn_templates as $tmpl ){
            
            $content_obj = new wpsr_template_button_handler( $tmpl, 'content' );
            $excerpt_obj = new wpsr_template_button_handler( $tmpl, 'excerpt' );
            
            add_filter( 'the_content', array( $content_obj, 'print_template' ), 10 );
            add_filter( 'the_excerpt', array( $excerpt_obj, 'print_template' ), 10 );
            
        }
        
    }
    
    public static function html( $template, $page_info = array() ){
        
        $decoded = base64_decode( $template );
        $rows = json_decode( $decoded );
        $html = '';
        $row_buttons = array();
        $buttons = WPSR_Buttons::list_all();
        
        if( !is_object( $rows ) || empty( $rows ) )
            return array(
                'html' => '',
                'buttons' => ''
            );
        
        // Apply filters on the template rows
        $rows = apply_filters( 'wpsr_mod_buttons_template', $rows );
        
        foreach( $rows as $row ){
            if( count( $row->buttons ) > 0 ){
                $html .= '<div class="wp-socializer wpsr-buttons">';
                foreach( $row->buttons as $button ){
                    $btn_id = key( ( array )$button );
                    array_push( $row_buttons, $btn_id );
                    
                    if( !array_key_exists( $btn_id, $buttons ) ){
                        continue;
                    }
                    
                    $wrap_tag = 1;
                    $btn_settings = $buttons[ $btn_id ][ 'settings' ];
                    $service_id = $buttons[ $btn_id ][ 'service' ];
                    if ( isset( $btn_settings[ '_wrap_tag' ] ) && $btn_settings[ '_wrap_tag' ] == 0 ){
                        $wrap_tag = 0;
                    }
                    
                    $classes = apply_filters( 'wpsr_mod_button_classes', array( 'wpsr-btn', 'wpsr-srvc-' . $service_id ) );
                    $classes = join( ' ', $classes );
                    
                    $btn_html = WPSR_Buttons::get_button( $btn_id, $page_info );
                    $html .= $wrap_tag ? '<span class="' . $classes . '">' . $btn_html . '</span>' : $btn_html;
                }
                $html .= '</div>';
            }
        }
        
        $out = array(
            'html' => $html,
            'buttons' => $row_buttons
        );
        
        return apply_filters( 'wpsr_mod_buttons_template_html', $out );
        
    }
    
    public static function preview( $template ){
        
        if( !isset( $_GET[ 'template' ] ) ){
            die(0);
        }
        
        $template = wp_kses_post( $_GET[ 'template' ] );
        $page_info = array(
            'title' => 'Google',
            'url' => 'https://www.google.com',
            'excerpt' => 'Dummy excerpt for WP Socializer preview',
            'short_url' => 'https://goo.gl/lightsaber',
            'comments_count' => '45',
            'post_id' => 1
        );
        
        // Generate HTML for the template
        $gen_out = self::html( $template, $page_info );
        
        echo '<!doctype html><html lang="en"><head><meta charset="utf-8"><title>' . __( 'WP Socializer template preview', 'wpsr' ) . '</title>';
        
        
        echo '</head><body>' . $gen_out[ 'html' ];
        
        WPSR_Includes::preview_print_includes();
        
        echo '</body></html>';
        
        die(0);
        
    }
    
}

class WPSR_Template_Sharebar{
    
    public static function init(){
        
        add_action( 'wp_footer', array( __CLASS__, 'output' ) );
        
        add_action( 'wp_ajax_wpsr_preview_template_sharebar', array( __CLASS__, 'preview' ) );
        
    }
    
    public static function output(){

        $sb_settings = wp_parse_args( get_option( 'wpsr_sharebar_settings' ), WPSR_Lists::defaults( 'sharebar' ) );
        $loc_rules_answer = WPSR_Location_Rules::check_rule( $sb_settings[ 'loc_rules' ] );
        
        if( $sb_settings[ 'ft_status' ] != 'disable' && $loc_rules_answer ){
            $gen_out = self::html( $sb_settings );
            echo $gen_out[ 'html' ];
            do_action( 'wpsr_do_sharebar_print_template_end' );
        }
        
    }
    
    public static function html( $opts, $page_info = array() ){
        
        $html = '';
        $buttons = array();
        $classes = array();
        $styles = array();
        
        $decoded = base64_decode( $opts[ 'buttons' ] );
        $rows = json_decode( $decoded );
        
        if( !is_object( $rows ) || empty( $rows ) )
            return '';
        
        if( $opts[ 'type' ] == 'horizontal' ){
            array_push( $classes, 'wpsr-sb-hl-' . $opts[ 'hl_position' ] );
            #array_push( $styles, 'width:' . $opts[ 'hl_width' ] );
            array_push( $styles, ( $opts[ 'hl_position' ] == 'wbottom' ? 'bottom' : 'top' ) . ':' . $opts[ 'offset' ] );
        }else{
            array_push( $classes, 'wpsr-sb-vl-' . $opts[ 'vl_position' ] );
            array_push( $classes, 'wpsr-sb-vl-' . $opts[ 'vl_movement' ] );
            array_push( $styles, ( $opts[ 'vl_position' ] == 'wleft' ? 'left' : ( $opts[ 'vl_position' ] == 'scontent' ) ? 'margin-left' : 'right' ) . ':' . $opts[ 'offset' ] );
        }
        
        array_push( $classes, 'wpsr-sb-' . ( $opts[ 'type' ] == 'horizontal' ? 'hl' : 'vl' ) );
        array_push( $classes, 'wpsr-sb-' . $opts[ 'theme' ] );
        $classes = array_merge( $classes, explode( ',', $opts[ 'css_class' ] ) );
        
        if( $opts[ 'bg_color' ] != '' )
            array_push( $styles, 'background-color:' . $opts[ 'bg_color' ] );
        
        if( $opts[ 'border_color' ] != '' )
            array_push( $styles, 'border-color:' . $opts[ 'border_color' ] );
        
        if( $opts[ 'oc_color' ] == 'white' )
            array_push( $classes, 'wpsr-sb-wocbtn' );
        
        $classes = implode( ' ', $classes );
        $styles = implode( ';', $styles );
        
        // Apply filters
        $rows = apply_filters( 'wpsr_mod_sharebar_template', $rows );
        
        foreach( $rows as $row ){
            if( count( $row->buttons ) > 0 ){
                $html .= '<div class="wp-socializer wpsr-sharebar ' . esc_attr( $classes ) . '" style="' . esc_attr( $styles ) . '" data-stickto="' . esc_attr( $opts[ 'stick_element' ] ) . '">';
                $html .= '<div class="wpsr-sb-inner">';
                
                foreach( $row->buttons as $button ){
                    $btn = key( ( array )$button );
                    array_push( $buttons, $btn );
                    $html .= '<span class="wpsr-btn">' . WPSR_Buttons::get_button( $btn, $page_info ) . '</span>';
                }
                $html .= '</div>';
                $html .= '<div class="wpsr-sb-close" title="Open or close sharebar"><span class="wpsr-icon"></span></div>';
                $html .= '</div>';
            }
            break;
        }
        
        $out = array(
            'html' => $html,
            'buttons' => $buttons
        );
        
        return apply_filters( 'wpsr_mod_sharebar_template_html', $out );
        
    }
    
    public static function preview(){
        
        $g = $_GET;
        
        $page_info = array(
            'title' => 'Google',
            'url' => 'https://www.google.com',
            'excerpt' => 'Dummy excerpt for WP Socializer preview',
            'short_url' => 'https://goo.gl/lightsaber',
            'comments_count' => '45',
            'post_id' => 1
        );
        $g[ 'stick_element' ] = '#main_content';
        
        // Generate HTML for the template
        $gen_out = self::html( $g, $page_info );
        
        echo '<!doctype html><html lang="en"><head><meta charset="utf-8"><title>WP Socializer template preview</title>';
        echo '<script src="' . WPSR_Lists::ext_res( 'jquery' ) . '"></script>';
        echo '<script src="' . WPSR_ADMIN_URL . 'js/sharebar_preview.js"></script>';
        echo '<link href="' . WPSR_ADMIN_URL . 'css/sharebar_preview.css" rel="stylesheet" type="text/css" media="all" />';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1" />';
        
        $dmap = array(
            'vertical' => array(
                'tdec' => __( 'left', 'wpsr' ),
                'tinc' => __( 'right', 'wpsr' ),
            ),
            'horizontal' => array(
                'tdec' => __( 'up', 'wpsr' ),
                'tinc' => __( 'down', 'wpsr' )
            ),
        );
        
        $change_offset = '';
        $utext = array();
        if( $g[ 'type' ] == 'horizontal' ){
            $change_offset = ( $g[ 'hl_position' ] == 'wbottom' ) ? 'bottom' : 'top';
            $utext = $dmap[ 'horizontal' ];
        }else{
            $change_offset = ( $g[ 'vl_position' ] == 'wleft' ) ? 'left' : ( $g[ 'vl_position' ] == 'scontent' ) ? 'margin-left': 'right';
            $utext = $dmap[ 'vertical' ];
        }
        
        echo '</head>';
        echo '<body>' . $gen_out[ 'html' ];
        echo '
        <div id="main_content"></div>
        <div class="adjust_bar">
            <h3>' . __( 'Preview and Settings', 'wpsr' ) . '</h3>
            <h4>' . __( 'Adjust sharebar position from window', 'wpsr' ) . '</h4>
            <p>' . sprintf( __( 'Drag the slider below to adjust the sharebar position %s or %s', 'wpsr' ), $utext[ 'tdec' ], $utext[ 'tinc' ] ) . '</p>
            <div class="adj_btn_wrap"><input type="range" class="offset_drag" min="-500" max="500" step="1" width="100%" value="' . intval( $g[ 'offset' ] ) . '" data-coffset="' . $change_offset . '"/><input type="text" class="offset_val" value="' . intval( $g[ 'offset' ] ) . 'px" /></div>
            <div class="adj_footer"><button class="save_btn">' . __( 'Save and close', 'wpsr' ) . '</button> <button class="close_btn">' . __( 'Close without saving', 'wpsr' ) . '</button></div>
        </div>';
        
        WPSR_Includes::preview_print_includes();
        
        echo '</body></html>';
        
        die(0);
    }
    
}

class WPSR_Template_Followbar{
    
    public static function init(){
        
        add_action( 'wp_footer', array( __CLASS__, 'output' ) );
                
    }
    
    public static function output(){

        $fb_settings = get_option( 'wpsr_followbar_settings' );
        $loc_rules_answer = WPSR_Location_Rules::check_rule( $fb_settings[ 'loc_rules' ] );
        
        if( $fb_settings[ 'ft_status' ] != 'disable' && $loc_rules_answer ){
            $gen_html = self::html( $fb_settings );
            echo $gen_html;
            do_action( 'wpsr_do_followbar_print_template_end' );
        }
        
    }
    
    public static function html( $opts, $floating = True ){
        
        $opts = wp_parse_args( $opts, WPSR_Lists::defaults( 'followbar' ) );
        $template = $opts[ 'template' ];
        $decoded = base64_decode( $template );
        $btns = json_decode( $decoded );
        $sb_sites = WPSR_Lists::social_buttons();
        $html = '';
        
        if( !is_array( $btns ) ){
            return '';
        }
        
        $styles = array();
        if ( $opts[ 'bg_color' ] != '' ) array_push( $styles, 'background-color: ' . $opts[ 'bg_color' ] . ';border-color: ' . $opts[ 'bg_color' ] );
        if ( $opts[ 'icon_color' ] != '' ) array_push( $styles, 'color: ' . $opts[ 'icon_color' ] );
        $style = join( ';', $styles );
        
        $text_class = ( $opts[ 'text' ] != 'hide' ) ? 'sr-text-' . $opts[ 'text' ] : '';
        
        foreach( $btns as $btn_obj ){
            
            $id = key( (array) $btn_obj );
            $prop = $sb_sites[ $id ];
            
            $cicon = '';
            if ( $btn_obj->$id->icon != '' ){
                $cicon = 'sr-cicon';
                $style = '';
            }
            
            $iclasses = array( 'sr-' . $id, $text_class, $cicon );
            $onclick = array_key_exists( 'onclick', $prop ) ? 'onclick="' . esc_attr( $prop[ 'onclick' ] ) . '"' : '';
            
            $html .= '<span class="' . esc_attr( join( ' ', $iclasses ) ) . '">';
            $html .= '<a rel="nofollow" href="' . esc_attr( $btn_obj->$id->url ) . '" target="_blank" title="' . esc_attr( $prop[ 'name' ] ) . '" style="' . esc_attr( $style ) . '" ' . $onclick . '>';
            
            if( $btn_obj->$id->icon == '' ){
                $html .= '<i class="fa fa-' . esc_attr( $prop[ 'icon' ] ) . '"></i>';
            }else{
                $html .= '<img src="' . esc_attr( $btn_obj->$id->icon ) . '" alt="' . esc_attr( $prop[ 'name' ] ) . '" />';
            }
            
            $html .= '</a>';
            
            if( $text_class != '' ){
                $html .= '<span class="text">' . ( ( $btn_obj->$id->text == '' ) ? $prop[ 'name' ] : $btn_obj->$id->text ) . '</span>';
            }
            
            $html .= '</span>';
            
        }
        
        $classes = array( 'socializer', 'sr-followbar', 'sr-' . $opts[ 'size' ] );
        
        if( $opts[ 'shape' ] != '' ) array_push( $classes, 'sr-' . $opts[ 'shape' ] );
        if( $opts[ 'hover' ] != '' ) array_push( $classes, 'sr-' . $opts[ 'hover' ] );
        if( $opts[ 'pad' ] != '' ) array_push( $classes, 'sr-' . $opts[ 'pad' ] );
        if( $opts[ 'orientation' ] == 'vertical' ) array_push( $classes, 'sr-vertical' );
        if( $opts[ 'open_popup' ] == '' ) array_push( $classes, 'sr-popup' );
        if( !$floating ) array_push( $classes, 'sr-multiline' );
        
        $classes = join( ' ', $classes );
        
        $html = '<div class="' . $classes . '">' . $html . '</div>';
        
        if( $floating ){
            $title = ( $opts[ 'title' ] != '' ) ? '<div class="sr-fb-title">' . $opts[ 'title' ] . '</div>' : '';
            $orientation = ( $opts[ 'orientation' ] == 'horizontal' ) ? 'sr-fb-hl' : 'sr-fb-vl';
            $fb_classes = array( 'wpsr-followbar', 'sr-fb-' . $opts[ 'position' ], $orientation );
            $html = '<div class="' . esc_attr( join( ' ', $fb_classes ) ) . '">' . $title . $html . '</div>';
        }
        
        if( !$floating && isset( $opts[ 'profile_text' ] ) && trim( $opts[ 'profile_text' ] ) != '' ){
            $html = '<p>' . $opts[ 'profile_text' ] . '</p>' . $html;
        }
        
        return $html;
        
    }
    
}

class WPSR_Template_Text_Sharebar{
    
    public static function init(){
        
        add_action( 'wp_footer', array( __CLASS__, 'output' ) );
        
    }
    
    public static function output(){

        $tsb_settings = get_option( 'wpsr_text_sharebar_settings' );
        $loc_rules_answer = WPSR_Location_Rules::check_rule( $tsb_settings[ 'loc_rules' ] );
        
        if( $tsb_settings[ 'ft_status' ] != 'disable' && $loc_rules_answer && !wp_is_mobile() ){
            $gen_html = self::html( $tsb_settings );
            echo $gen_html;
            do_action( 'wpsr_do_text_sharebar_print_template_end' );
        }
        
    }
    
    public static function html( $opts ){
        
        $opts = wp_parse_args( $opts, WPSR_Lists::defaults( 'text_sharebar' ) );
        $template = $opts[ 'template' ];
        $decoded = base64_decode( $template );
        $btns = json_decode( $decoded );
        $sb_sites = WPSR_Lists::social_buttons();
        $page_info = WPSR_Metadata::metadata();
        $html = '';
        
        $g_settings = get_option( 'wpsr_general_settings' );
        $g_settings = wp_parse_args( $g_settings, WPSR_Lists::defaults( 'gsettings_twitter' ) );
        $t_username = ( $g_settings[ 'twitter_username' ] != '' ) ? '@' . $g_settings[ 'twitter_username' ] : '';
        
        if( !is_array( $btns ) ){
            return '';
        }
        
        foreach( $btns as $btn ){
            $sb_info = $sb_sites[ $btn ];
            $link = array_key_exists( 'link_tsb', $sb_info ) ? $sb_info[ 'link_tsb' ] : $sb_info[ 'link' ];
            $onclick = array_key_exists( 'onclick', $sb_info ) ? 'onclick="' . esc_attr( $sb_info[ 'onclick' ] ) . '"' : '';
            
            $html .= '<li><a href="#" title="' . esc_attr( $sb_info[ 'title' ] ) . '" data-link="' . esc_attr( $link ) . '" style="color: ' . esc_attr( $opts[ 'icon_color' ] ) . '" ' . $onclick . '><i class="fa fa-' . esc_attr( $sb_info[ 'icon' ] ) . '"></i></a></li>';
        }
        
        $html = '<ul class="wpsr-text-sb wpsr-tsb-' . esc_attr( $opts[ 'size' ] ) . ' wpsr-clearfix" data-content="' . esc_attr( $opts[ 'content' ] ) . '" data-tcount="' . esc_attr( $opts[ 'text_count' ] ) . '" style="background-color: ' . esc_attr( $opts[ 'bg_color' ] ) . '" data-url="' . esc_attr( $page_info[ 'url' ] ) . '" data-title="' . esc_attr( $page_info[ 'title' ] ) . '" data-surl="' . esc_attr( $page_info[ 'short_url' ] ) . '" data-tuname="' . esc_attr( $t_username ) . '">' . $html . '</ul>';
        
        return $html;
        
    }
    
}

class WPSR_Template_Mobile_Sharebar{
    
    public static function init(){
        
        add_action( 'wp_footer', array( __CLASS__, 'output' ) );
        
    }
    
    public static function output(){

        $msb_settings = get_option( 'wpsr_mobile_sharebar_settings' );
        $loc_rules_answer = WPSR_Location_Rules::check_rule( $msb_settings[ 'loc_rules' ] );
        
        if( $msb_settings[ 'ft_status' ] != 'disable' && $loc_rules_answer && ( wp_is_mobile() || $msb_settings[ 'on_desktop' ] == 'yes' ) ){
            $gen_html = self::html( $msb_settings );
            echo $gen_html;
            do_action( 'wpsr_do_mobile_sharebar_print_template_end' );
        }
        
    }
    
    public static function html( $opts ){
        
        $opts = wp_parse_args( $opts, WPSR_Lists::defaults( 'mobile_sharebar' ) );
        $template = $opts[ 'template' ];
        $decoded = base64_decode( $template );
        $btns = json_decode( $decoded );
        $sb_sites = WPSR_Lists::social_buttons();
        $page_info = WPSR_Metadata::metadata();
        $html = '';
        
        if( !is_array( $btns ) ){
            return '';
        }
        
        $styles = array();
        if ( $opts[ 'bg_color' ] != '' ) array_push( $styles, 'background-color: ' . $opts[ 'bg_color' ] );
        if ( $opts[ 'icon_color' ] != '' ) array_push( $styles, 'color: ' . $opts[ 'icon_color' ] );
        $style = join( ';', $styles );
        
        foreach( $btns as $btn ){
            $sb_info = $sb_sites[ $btn ];
            $link = self::get_url( $sb_info[ 'link' ], $page_info );
            $onclick = array_key_exists( 'onclick', $sb_info ) ? 'onclick="' . esc_attr( $sb_info[ 'onclick' ] ) . '"' : '';
            
            $html .= '<span class="sr-' . $btn . '"><a rel="nofollow" target="_blank" href="' . esc_attr( $link ) . '" title="' . esc_attr( $sb_info[ 'title' ] ) . '" style="' . $style . '" ' . $onclick . '><i class="fa fa-' . esc_attr( $sb_info[ 'icon' ] ) . '" tar></i></a></span>';
        }
        
        $classes = array( 'socializer', 'wpsr-mobile-sb', 'sr-' . $opts[ 'size' ], 'sr-fluid', 'sr-opacity', 'sr-popup' );
        
        if( $opts[ 'pad' ] != '' ) array_push( $classes, 'sr-' . $opts[ 'pad' ] );
        
        $classes = join( ' ', $classes );
        
        $html = '<div class="' . $classes . '">' . $html . '</div>';
        
        return $html;
        
    }
    
    public static function get_url( $url, $pinfo ){
        
        $g_settings = get_option( 'wpsr_general_settings' );
        $g_settings = wp_parse_args( $g_settings, WPSR_Lists::defaults( 'gsettings_twitter' ) );
        $t_username = ( $g_settings[ 'twitter_username' ] != '' ) ? '@' . $g_settings[ 'twitter_username' ] : '';
        
        $search = array(
            '{url}',
            '{title}',
            '{excerpt}',
            '{s-url}',
            '{rss-url}',
            '{twitter-username}',
        );
        
        $replace = array(
            $pinfo[ 'url' ],
            $pinfo[ 'title' ],
            $pinfo[ 'excerpt' ],
            $pinfo[ 'short_url' ],
            $pinfo[ 'rss_url' ],
            $t_username
        );
        
        return str_replace( $search, $replace, $url );
    }
    
}

WPSR_Template_Buttons::init();
WPSR_Template_Sharebar::init();
WPSR_Template_Followbar::init();
WPSR_Template_Text_Sharebar::init();
WPSR_Template_Mobile_Sharebar::init();

class wpsr_template_button_handler{
    
    private $props;
    private $type;
    
    function __construct( $properties, $type ){
        
        $this->props = $properties;
        $this->type = $type;
        
    }
    
    function print_template( $content ){
        
        $call_from_excerpt = 0;
        $call_stack = debug_backtrace();
        
        foreach( $call_stack as $call ){
            if( $call['function'] == 'the_excerpt' || $call['function'] == 'get_the_excerpt' ){
                $call_from_excerpt = 1;
            }
        }
        
        $loc_rules_answer = WPSR_Location_Rules::check_rule( $this->props[ 'loc_rules' ] );
        $rule_in_excerpt = ( $this->props[ 'in_excerpt' ] == 'show' );
        $output = $content;
        
        if( $loc_rules_answer ){
            
            if( ( $this->type == 'content' && $call_from_excerpt != 1 ) || ( $this->type == 'excerpt' && $rule_in_excerpt == 1 ) ){
                
                $gen_out = WPSR_Template_Buttons::html( $this->props[ 'content' ] );
                
                if( !empty( $gen_out[ 'html' ] ) ){
                
                    $final_template = $gen_out[ 'html' ];
                    
                    if( $this->props[ 'position' ] == 'above_below_posts' )
                        $output = $final_template . $content . $final_template;
                    
                    if( $this->props[ 'position' ] == 'above_posts' )
                        $output = $final_template . $content;
                    
                    if( $this->props[ 'position' ] == 'below_posts' )
                        $output = $content . $final_template;
                    
                }
            }
            
            do_action( 'wpsr_do_buttons_print_template_end' );
            
        }
        
        return $output;
        
    }
    
}

?>