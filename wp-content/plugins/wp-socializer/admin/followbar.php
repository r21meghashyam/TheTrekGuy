<?php
/**
 * Follow bar admin page helpers
 *
 **/

class WPSR_Followbar{
    
    public static function init(){
        
        add_action( 'wp_ajax_wpsr_followbar_editor', array( __CLASS__, 'popup_editor' ) );
        
    }
    
    function popup_editor(){
        
        global $hook_suffix;
        $hook_suffix = WPSR_Admin::$pagehook;
        set_current_screen( $hook_suffix );
        
        iframe_header( 'WP Socializer follow bar editor' );
        
        if( !isset( $_GET[ 'template' ] ) || !isset( $_GET[ 'cnt_id' ] ) || !isset( $_GET[ 'prev_id' ] ) ){
            echo '<p align="center">Incomplete info to load editor !</p></body></html>';
            //die( 0 );
        }
        
        $sb_sites = WPSR_Lists::social_buttons();
        echo '<script>window.social_buttons = ' . json_encode( $sb_sites ) . ';</script>';
        echo '<script>window.li_template = \'' . self::li_template() . '\';</script>';
        
        echo '<div id="wpsr_pp_editor">';
        echo '<h3>WP Socializer - follow bar editor</h3>';
        WPSR_Admin::box_wrap( 'open', __( 'Add buttons to follow bar', 'wpsr' ), __( 'Select a social media button from the list and add it to the list', 'wpsr' ), '1' );
        
        echo '<table class="form-table"><tr><td width="90%">';
        echo '<select class="fb_list widefat">';
        foreach( $sb_sites as $id=>$prop ){
            echo '<option value="' . $id . '">' . $prop[ 'name' ] . '</option>';
        }
        echo '</select>';
        echo '</td><td>';
        echo '<button class="fb_add button button-primary widefat">Add button</button>';
        echo '</td></tr></table>';
        
        $template = self::read_template( esc_attr( $_GET[ 'template' ] ) );
        echo '<ul class="fb_selected">';
        echo $template[ 'editor' ];
        echo '</ul>';
        
        echo '<input type="hidden" class="fb_template" />';
        
        WPSR_Admin::box_wrap( 'close' );
        
        echo '<p class="wpsr_ppe_footer" align="center"><button class="button button-primary wpsr_ppe_save" data-mode="followbar" data-cnt-id="' . esc_attr( $_GET[ 'cnt_id' ] ) . '" data-prev-id="' . esc_attr( $_GET[ 'prev_id' ] ) . '">Apply settings</button> <button class="button wpsr_ppe_cancel">Cancel</button></p>';
        
        echo '</div>';
        
        iframe_footer();
        die( 0 );
        
    }
    
    public static function read_template( $template = '' ){

        $decoded = base64_decode( $template );
        $btns = json_decode( $decoded );
        
        if( !is_array( $btns ) ){
            return array(
                'prev' => '',
                'editor' => ''
            );
        }
        
        $sb_sites = WPSR_Lists::social_buttons();
        $editor = '';
        $prev = '';
        
        foreach( $btns as $btn_obj ){
            
            $id = key( (array) $btn_obj );
            $prop = $sb_sites[ $id ];
            
            $editor .= self::li_template( $id, $prop[ 'name' ], $prop[ 'icon' ], $prop[ 'colors' ][0], $btn_obj->$id->url, $btn_obj->$id->icon, $btn_obj->$id->text );
            $prev .= '<li style="background-color:' . $prop[ 'colors' ][0] . '"><i class="fa fa-' . $prop[ 'icon' ] . '"></i></li>';
        }
        
        if( $prev == '' )
            $prev = '<span>No buttons are added. Open the editor to add buttons.</span>';
        
        $prev = '<ul class="fb_preview">' . $prev . '</ul>';
        
        return array(
            'editor' => $editor,
            'prev' => $prev
        );
        
    }
    
    public static function li_template( $id = '%id%', $name = '%name%', $icon = '%icon%', $color = '%color%', $url = '%url%', $iurl = '%iurl%', $text = '%text%' ){
        $title = __( 'Leave blank to use default', 'wpsr' );
        
        return '<li data-id="' . $id . '"><h4 style="background-color: ' . $color . '"><i class="fa fa-' . $icon . ' item_icon"></i>' . $name . '<a href="#" class="fb_item_remove">' . __( 'Delete', 'wpsr' ) . '</a></h4><div><label>Button URL: <input type="text" class="widefat fb_item_url" placeholder="Enter profile URL" value="' . $url . '" /></label><label>Button text: <input type="text" class="widefat fb_btn_text" title="' . $title . '" placeholder="Enter custom text to show for button" value="' . $text . '"/></label><label>Icon image URL: <input type="text" class="widefat fb_icon_url" placeholder="Enter custom Icon URL." title="' . $title . '" value="' . $iurl . '"/></label></div></li>';
    }
    
}

WPSR_Followbar::init();

/**
 * Follow bar admin page
 */

class wpsr_admin_followbar{
    
    function __construct(){
        
        WPSR_Admin::add_tab( 'followbar', array(
            'name' => 'Follow Bar',
            'banner' => WPSR_ADMIN_URL . '/images/banners/followbar.png',
            'page_callback' => array( $this, 'page' ),
            'form' => array(
                'id' => 'followbar_settings',
                'name' => 'followbar_settings',
                'callback' => array( $this, 'form_fields' ),
                'validation' => array( $this, 'validation' ),
            )
        ));
        
    }
    
    function form_fields( $values ){
        
        $values = wp_parse_args( $values, WPSR_Lists::defaults( 'followbar' ) );
        
        $section0 = array(
            array( __( 'Select to enable or disable follow bar feature', 'wpsr' ), WPSR_Admin::field( 'select', array(
                'name' => 'ft_status',
                'value' => $values[ 'ft_status' ],
                'list' => array(
                    'enable' => __( 'Enable follow bar', 'wpsr' ),
                    'disable' => __( 'Disable follow bar', 'wpsr' )
                ),
            )), 'class="ft_table"' ),
        );
        
        WPSR_Admin::youtube_help_icon( 'https://www.youtube.com/watch?v=2v5VTYzZcMo' );
        
        WPSR_Admin::build_table( $section0, __( 'Enable/disable follow bar', 'wpsr' ), '', false, '1' );
        
        $template = WPSR_Followbar::read_template( $values[ 'template' ] );
        
        echo '<div class="feature_wrap">';
        
        // Section 1
        WPSR_Admin::box_wrap( 'open', __( 'Add and edit follow bar buttons', 'wpsr' ), __( 'Below are the buttons added to follow bar. Open editor to add and rearrange the buttons.', 'wpsr' ), '2' );
        echo '<h4>' . __( 'Selected buttons', 'wpsr' ) . '</h4>';
        echo '<div id="fb_prev_wrap">' . $template[ 'prev' ] . '</div>';
        
        echo '<input type="hidden" id="fb_template_val" name="template" value="' . $values[ 'template' ] . '" />';
        echo '<p align="center"><button class="button button-primary wpsr_ppe_fb_open" data-cnt-id="fb_template_val" data-prev-id="fb_prev_wrap">' . __( 'Open editor', 'wpsr' ) . '</button></p>';
        WPSR_Admin::box_wrap( 'close' );
        
        // Section 2
        $section2 = array(
            array( __( 'Button shape', 'wpsr' ), WPSR_Admin::field( 'select', array(
                'name' => 'shape',
                'value' => $values['shape'], 
                'list' => array(
                    '' => 'Square',
                    'circle' => 'Circle',
                    'squircle' => 'Squircle',
                    'squircle-2' => 'Squircle 2',
                    'diamond' => 'Diamond',
                    'ribbon' => 'Ribbon',
                    'drop' => 'Drop',
                ),
            ))),
            
            array( __( 'Button size', 'wpsr' ), WPSR_Admin::field( 'select', array(
                'name' => 'size',
                'value' => $values['size'], 
                'list' => array(
                    '32px' => '32px',
                    '16px' => '16px',
                    '48px' => '48px',
                    '64px' => '64px',
                ),
            ))),
            
            array( __( 'Button background color', 'wpsr' ), WPSR_Admin::field( 'text', array(
                'name' => 'bg_color',
                'value' => $values['bg_color'],
                'class' => 'color_picker',
                'helper' => __( 'Set empty value to use automatic background color', 'wpsr' )
            ))),
            
            array( __( 'Icon color', 'wpsr' ), WPSR_Admin::field( 'text', array(
                'name' => 'icon_color',
                'value' => $values['icon_color'],
                'class' => 'color_picker'
            ))),
            
            array( __( 'Orientation', 'wpsr' ), WPSR_Admin::field( 'select', array(
                'name' => 'orientation',
                'value' => $values['orientation'], 
                'list' => array(
                    'vertical' => __( 'Vertical', 'wpsr' ),
                    'horizontal' => __( 'Horizontal', 'wpsr' )
                ),
            ))),
            
            array( __( 'Position', 'wpsr' ), WPSR_Admin::field( 'select', array(
                'name' => 'position',
                'value' => $values['position'], 
                'list' => array(
                    'tl' => __( 'Top left', 'wpsr' ),
                    'tm' => __( 'Top middle', 'wpsr' ),
                    'tr' => __( 'Top right', 'wpsr' ),
                    'rm' => __( 'Right middle', 'wpsr' ),
                    'br' => __( 'Bottom right', 'wpsr' ),
                    'bm' => __( 'Bottom middle', 'wpsr' ),
                    'bl' => __( 'Bottom left', 'wpsr' ),
                    'lm' => __( 'Left middle', 'wpsr' ),
                ),
            ))),
            
            array( __( 'Text style', 'wpsr' ), WPSR_Admin::field( 'select', array(
                'name' => 'text',
                'value' => $values['text'], 
                'list' => array(
                    'hide' => __( 'Hide button text', 'wpsr' ),
                    'hover' => __( 'Show text on hover', 'wpsr' )
                ),
            ))),
            
            array( __( 'Hover effect', 'wpsr' ), WPSR_Admin::field( 'select', array(
                'name' => 'hover',
                'value' => $values['hover'], 
                'list' => array(
                    '' => __( 'None', 'wpsr' ),
                    'opacity' => 'Opacity',
                    'rotate' => 'Rotate',
                    'zoom' => 'Zoom',
                    'shrink' => 'Shrink',
                    'float' => 'Float',
                    'sink' => 'Sink'
                ),
            ))),
            
            array( __( 'Gutters', 'wpsr' ), WPSR_Admin::field( 'select', array(
                'name' => 'pad',
                'value' => $values['pad'],
                'list' => array(
                    '' =>  __( 'No', 'wpsr' ),
                    'pad' =>  __( 'yes', 'wpsr' )
                ),
                'helper' => __( 'Select to add space between buttons', 'wpsr' )
            ))),
            
            array( __( 'Title', 'wpsr' ), WPSR_Admin::field( 'text', array(
                'name' => 'title',
                'value' => $values['title'],
                'helper' => __( 'Text to show above the follow bar', 'wpsr' ),
            ))),
            
            array( __( 'Open links in popup', 'wpsr' ), WPSR_Admin::field( 'select', array(
                'name' => 'open_popup',
                'value' => $values['open_popup'],
                'list' => array(
                    'no' =>  'No',
                    '' =>  'yes',
                ),
            ))),
            
        );
        
        WPSR_Admin::build_table( $section2, __( 'Settings', 'wpsr' ), '', false, '3' );
        
        
        // Location rules
        WPSR_Admin::box_wrap( 'open', __( 'Conditions to display the followbar', 'wpsr' ), __( 'Choose the below options to select the pages which will display the followbar.', 'wpsr' ), '4' );
        WPSR_Location_Rules::display_rules( "loc_rules", $values['loc_rules'] );
        WPSR_Admin::box_wrap( 'close' );
        
        echo '</div>';
    }
    
    function page(){
        
        WPSR_Admin::settings_form( 'followbar' );
        
    }
    
    function validation( $input ){
        return $input;
    }
    
}

new wpsr_admin_followbar();

/**
 * Follow bar widget
 */
 
class wpsr_widget_followbar{
    
    function __construct(){
        
        WPSR_Widgets::register( 'followbar_widget', array(
            'name' => 'Follow me/us icons widget',
            'callbacks' => array(
                'widget' => array( $this, 'widget' ),
                'form' => array( $this, 'form' ),
                'update' => array( $this, 'update' )
            )
        ));
        
        $this->defaults = array(
            'template' => '',
            'orientation' => 'horizontal',
            'shape' => '',
            'size' => '32px',
            'bg_color' => '',
            'icon_color' => '#ffffff',
            'text' => 'hide',
            'hover' => 'opacity',
            'pad' => 'pad',
            'profile_text' => ''
        );
        
    }
    
    function widget( $args, $instance ){
        
        $instance = wp_parse_args( $instance, $this->defaults );
        
        $html = WPSR_Template_Followbar::html( $instance, False );
        echo $html;
        
    }
    
    function form( $obj, $instance ){
        
        echo '<h4>' . __( 'Follow bar widget', 'wpsr' ) . '</h4>';
        
        $instance = wp_parse_args( $instance, $this->defaults );
        $fields = new WPSR_Widget_Form_Fields( $obj, $instance );
        
        $wtmpl_val = esc_attr( $instance[ 'template' ] );
        $wtmpl_cnt_id = $obj->get_field_id( 'template' );
        $wtmpl_prev_id = $obj->get_field_id( 'fbw_prev' );
        
        echo '<div class="hidden">';
        $fields->text( 'template', '' );
        $fields->text( 'orientation', '' );
        echo '</div>';
        
        echo '<h5>' . __( 'Selected buttons', 'wpsr' ) . '</h5>';
        echo '<div class="wpsr_wtmpl_wrap clearfix" id="' . $wtmpl_prev_id . '">';
        $tmpl = WPSR_Followbar::read_template( $wtmpl_val );
        echo $tmpl[ 'prev' ];
        echo '</div>';
        
        echo '<p align="center"><button class="button button-primary wpsr_ppe_fb_open" data-wtmpl-cnt-id="' . $wtmpl_cnt_id . '" data-wtmpl-prev-id="' . $wtmpl_prev_id . '">' . __( 'Open editor', 'wpsr' ) . '</button></p>';
        
        echo '<h5>' . __( 'Settings', 'wpsr' ) . '</h5>';
        $fields->select( 'shape', 'Button shape', array(
            '' => 'Square',
            'circle' => 'Circle',
            'squircle' => 'Squircle',
            'squircle-2' => 'Squircle 2',
            'diamond' => 'Diamond',
            'ribbon' => 'Ribbon',
            'drop' => 'Drop',
        ), array( 'class' => 'smallfat' ));
        
        $fields->select( 'size', 'Button size', array(
            '32px' => '32px',
            '16px' => '16px',
            '48px' => '48px',
            '64px' => '64px',
        ), array( 'class' => 'smallfat' ));
        
        $fields->text( 'bg_color', 'Button background color', array( 'class' => 'smallfat wpsr-color-picker' ));
        
        $fields->text( 'icon_color', 'Icon color', array( 'class' => 'smallfat wpsr-color-picker' ));
        
        $fields->select( 'text', 'Text style', array(
            'hide' => 'Hide button text',
            'hover' => 'Show text on hover'
        ), array( 'class' => 'smallfat' ));
        
        $fields->select( 'hover', 'Hover effect', array(
            '' => __( 'None', 'wpsr' ),
            'opacity' => 'Opacity',
            'rotate' => 'Rotate',
            'zoom' => 'Zoom',
            'shrink' => 'Shrink',
            'float' => 'Float',
            'sink' => 'Sink'
        ), array( 'class' => 'smallfat' ));
        
        $fields->select( 'pad', 'Gap between buttons', array(
            '' =>  'No',
            'pad' =>  'yes'
        ), array( 'class' => 'smallfat' ));
        
        $fields->text( 'profile_text', 'Text above buttons' );
        
    }
    
    function update( $instance ){
        return $instance;
    }
    
}
new wpsr_widget_followbar();

?>