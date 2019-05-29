<?php
/**
  * Buttons selection page
  *
  **/
  
class wpsr_admin_buttons{
    
    function __construct(){
        
        WPSR_Admin::add_tab( 'buttons', array(
            'name' => 'Share buttons',
            'banner' => WPSR_ADMIN_URL . '/images/banners/share-buttons.png',
            'page_callback' => array( $this, 'page' ),
            'form' => array(
                'id' => 'button_settings',
                'name' => 'button_settings',
                'callback' => array( $this, 'form_fields' ),
                'validation' => array( $this, 'validation' ),
            )
        ));
        
    }
    
    function section_addons_list(){
        
        $feature = array(
            'name' => 'buttons',
            'hide_services' => array()
        );
        
        WPSR_Admin::youtube_help_icon( 'https://www.youtube.com/watch?v=As7_mg_0Gms' );
        
        WPSR_Admin::box_wrap( 'open', __( 'Create buttons', 'wpsr' ), __( 'Select a service from the list to create a new button', 'wpsr' ), '1' );
        WPSR_Admin::buttons_selector( $feature );
        
        echo '<p>' . __( 'List of buttons created.', 'wpsr' ) . '</p>';
        $buttons = WPSR_Buttons::list_all();
        WPSR_Admin::buttons_list( 'all_buttons', $feature );
        
        WPSR_Admin::box_wrap( 'close' );
        
    }

    function section_templates( $values, $i ){
        
        if( !isset( $values[ 'tmpl' ][ $i ] ) ){
            $values[ 'tmpl' ][ $i ] = WPSR_Lists::defaults( 'buttons' );
        }else{
            $values[ 'tmpl' ][ $i ] = wp_parse_args( $values[ 'tmpl' ][ $i ], WPSR_Lists::defaults( 'buttons' ) );
        }
        
        echo '<div class="template_wrap" data-id="' . $i . '">';

        WPSR_Admin::box_wrap( 'open', __( 'Drag &amp; drop buttons into template', 'wpsr' ), __( 'Drag the buttons from the above list and drop it into the template below. Click "+" to add a new row. Click and drag row to rearrange its order.', 'wpsr' ), '2' );
        WPSR_Admin::buttons_veditor( "tmpl[$i][content]", $values['tmpl'][$i]['content'], true, 'wpsr_preview_template_buttons' );
        WPSR_Admin::box_wrap( 'close' );
        
        // Location rules
        WPSR_Admin::box_wrap( 'open', __( 'Conditions to display the template', 'wpsr' ), __( 'Choose the below options to select the pages which will display the template.', 'wpsr' ), '3' );
        WPSR_Location_Rules::display_rules( "tmpl[$i][loc_rules]", $values['tmpl'][$i]['loc_rules'] );
        WPSR_Admin::box_wrap( 'close' );
        
        $positions = array(
            'above_posts' => __( 'Above posts', 'wpsr' ),
            'below_posts' => __( 'Below posts', 'wpsr' ),
            'above_below_posts' => __( 'Both above and below posts', 'wpsr' )
        );
        
        // Position rules
        WPSR_Admin::box_wrap( 'open', __( 'Position of template in the page', 'wpsr' ), __( 'Choose the below options to select the position the template in a page.', 'wpsr' ), '4' );
        
        echo WPSR_Admin::field( 'radio', array(
            'name' => 'tmpl[' . $i . '][position]',
            'list' => $positions,
            'value' => $values[ 'tmpl' ][ $i ][ 'position' ],
            'default' => 'above_below_post',
        ));
        
        echo '<hr/><p>' . __( 'Select whether to show this template in excerpts', 'wpsr' ) . '</p>';
        
        echo WPSR_Admin::field( 'radio', array(
            'name' => 'tmpl[' . $i . '][in_excerpt]',
            'list' => array( 'show' => __( 'Show in excerpt', 'wpsr' ), 'hide' => __( 'Hide in excerpt', 'wpsr' ) ),
            'value' => $values[ 'tmpl' ][ $i ][ 'in_excerpt' ],
            'default' => 'hide',
        ));
        
        WPSR_Admin::box_wrap( 'close' );
        
        echo '</div>'; // template_wrap
        
    }
    
    function form_fields( $values ){
        
        $values = wp_parse_args( $values, array(
            'tmpl' => array()
        ));
        
        $this->section_addons_list();
        
        $template_count = 3;
        
        echo '<ul class="template_tab clearfix">';
        for( $i = 1; $i <= $template_count; $i++ ){
            echo '<li>Template ' . $i . '</li>';
        }
        echo '</ul>';

        for( $i=1; $i<=$template_count; $i++ ){
            $this->section_templates( $values, $i );
        }

    }
    
    
    function page(){
        
        // Add settings form
        WPSR_Admin::settings_form( 'buttons' );
        
    }
    
    function validation( $input ){
        return $input;
    }
    
}

new wpsr_admin_buttons();

?>