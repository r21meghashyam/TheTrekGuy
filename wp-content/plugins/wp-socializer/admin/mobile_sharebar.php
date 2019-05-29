<?php
/**
  * Mobile sharebar settings page
  *
  **/
  
class wpsr_admin_mobile_sharebar{
    
    function __construct(){
        
        WPSR_Admin::add_tab( 'mobile_sharebar', array(
            'name' => 'Mobile sharebar',
            'page_callback' => array( $this, 'page' ),
            'banner' => WPSR_ADMIN_URL . '/images/banners/mobile-sharebar.png',
            'form' => array(
                'id' => 'mobile_sharebar_settings',
                'name' => 'mobile_sharebar_settings',
                'callback' => array( $this, 'form_fields' ),
                'validation' => array( $this, 'validation' ),
            )
        ));
        
    }

    function form_fields( $values ){
        
        $values = wp_parse_args( $values, WPSR_Lists::defaults( 'mobile_sharebar' ) );
        
        $section0 = array(
            array( __( 'Select to enable or disable mobile sharebar feature', 'wpsr' ), WPSR_Admin::field( 'select', array(
                'name' => 'ft_status',
                'value' => $values[ 'ft_status' ],
                'list' => array(
                    'enable' => __( 'Enable mobile sharebar', 'wpsr' ),
                    'disable' => __( 'Disable mobile sharebar', 'wpsr' )
                ),
            )), 'class="ft_table"' ),
        );
        
        WPSR_Admin::youtube_help_icon( 'https://www.youtube.com/watch?v=icWCD2xuxjQ' );
        
        WPSR_Admin::build_table( $section0, __( 'Enable/disable mobile sharebar', 'wpsr' ), '', false, '1' );
        
        echo '<div class="feature_wrap">';
        
        $sb_sites = WPSR_Lists::social_buttons();
        
        WPSR_Admin::box_wrap( 'open', __( 'Add buttons to mobile sharebar', 'wpsr' ), __( 'Select buttons from the list below and add it to the selected list.', 'wpsr' ), '2' );
        echo '<table class="form-table"><tr><td width="90%">';
        echo '<select class="ssb_list widefat">';
        foreach( $sb_sites as $id=>$prop ){
            echo '<option value="' . $id . '">' . $prop[ 'name' ] . '</option>';
        }
        echo '</select>';
        echo '</td><td>';
        echo '<button class="button button-primary ssb_add">' . __( 'Add button', 'wpsr' ) . '</button>';
        echo '</td></tr></table>';
        
        echo '<h4>' . __( 'Selected buttons', 'wpsr' ) . '</h4>';
        
        $decoded = base64_decode( $values[ 'template' ] );
        $msb_btns = json_decode( $decoded );
        
        if( !is_array( $msb_btns ) ){
            $msb_btns = array();
        }
        
        echo '<ul class="ssb_selected_list clearfix">';
        if( count( $msb_btns ) > 0 ){
            foreach( $msb_btns as $msb_item ){
                $sb_info = $sb_sites[ $msb_item ];
                echo '<li title="' . $sb_info[ 'name' ] . '" data-id="' . $msb_item . '"><i class="fa fa-' . $sb_info[ 'icon' ] . '"></i> <span class="ssb_remove" title="' . __( 'Delete button', 'wpsr' ) . '">x</span></li>';
            }
        }else{
            echo '<span class="ssb_empty">' . __( 'No buttons are selected for text sharebar', 'wpsr' ) . '</span>';
        }
        echo '</ul>';
        echo '<input type="hidden" name="template" class="ssb_template" value="' . $values[ 'template' ] . '"/>';
        
        WPSR_Admin::box_wrap( 'close' );
        
        # Settings form
        $section2 = array(
            
            array( __( 'Button size', 'wpsr' ), WPSR_Admin::field( 'select', array(
                'name' => 'size',
                'value' => $values['size'], 
                'list' => array(
                    '32px' => '32px',
                    '48px' => '48px',
                    '64px' => '64px',
                )
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
            
            array( __( 'Gutters', 'wpsr' ), WPSR_Admin::field( 'select', array(
                'name' => 'pad',
                'value' => $values['pad'],
                'list' => array(
                    '' =>  __( 'No', 'wpsr' ),
                    'pad' =>  __( 'yes', 'wpsr' )
                ),
                'helper' => __( 'Select to add space between buttons', 'wpsr' )
            ))),
            
            array( __( 'Show sharebar on desktops ?', 'wpsr' ), WPSR_Admin::field( 'select', array(
                'name' => 'on_desktop',
                'value' => $values['on_desktop'],
                'list' => array(
                    'no' =>  __( 'No', 'wpsr' ),
                    'yes' =>  __( 'yes', 'wpsr' )
                ),
            ))),
            
        );
        WPSR_Admin::build_table( $section2, __( 'Settings', 'wpsr' ), '', false, '3' );
        
        // Location rules
        WPSR_Admin::box_wrap( 'open', __( 'Conditions to display the mobile sharebar', 'wpsr' ), __( 'Choose the below options to select the pages which will display the mobile sharebar.', 'wpsr' ), '4' );
        WPSR_Location_Rules::display_rules( "loc_rules", $values['loc_rules'] );
        WPSR_Admin::box_wrap( 'close' );
        
        echo '</div>';
        
        echo '<script>';
        echo 'var sb_sites = ' . json_encode( $sb_sites ) . ';';
        echo '</script>';
        
    }
    
    
    function page(){
        
        WPSR_Admin::settings_form( 'mobile_sharebar' );
        
    }
    
    function validation( $input ){
        return $input;
    }
    
}

new wpsr_admin_mobile_sharebar();

?>