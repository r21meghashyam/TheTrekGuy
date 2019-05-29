<?php
/**
  * Share this service for WP Socializer
  *
  */

class wpsr_service_sharethis{
    
    function __construct(){
        
        WPSR_Services::register( 'sharethis', array(
            'name' => 'Share this',
            'icons' => WPSR_ADMIN_URL . '/images/icons/sharethis.png',
            'desc' => __( 'Create Sharethis buttons like social buttons with counter', 'wpsr' ),
            'settings' => array( 'size' => 'popup' ),
            'callbacks' => array(
                'output' => array( $this, 'output' ),
                'includes' => array( $this, 'includes' ),
                'settings' => array( $this, 'settings' ),
                'validation' => array( $this, 'validation' ),
                'general_settings' => array( $this, 'general_settings' ),
                'general_settings_validation' => array( $this, 'general_settings_validation' ),
            )
        ));
        
        $this->sites = WPSR_Lists::sharethis();
        
        $this->default_values = array(
            'type' => 'large',
        );
        
    }

    function output( $settings = array(), $page_info = array() ){
        
        $out = array();
        $html = '';
        $settings = wp_parse_args( $settings, $this->default_values );
        $saved = json_decode( base64_decode( $settings[ 'selected_sites' ] ) );
        
        if( $settings[ 'type' ] == 'none' ){
            $type = '';
        }else{
            $type = '_' . $settings[ 'type' ];
        }
        
        foreach( $saved as $site ){
            if( array_key_exists( $site, $this->sites ) ){
                $html .= '<span class="st_' . $site . $type . '" displayText="' . esc_attr( $this->sites[ $site ][ 'name' ] ) . '" st_url="' . esc_attr( $page_info[ 'url' ] ) . '" st_title="' . esc_attr( $page_info[ 'title' ] ) . '"></span>';
            }
        }
        
        $out['html'] = $html;
        $out['includes'] = array( 'sharethis_main_js' );
        return $out;
        
    }
    
    function includes(){
        
        $gs = wp_parse_args( get_option( 'wpsr_general_settings' ), WPSR_Lists::defaults( 'gsettings_sharethis' ) );
        
        $includes = array(
            'sharethis_main_js' => array(
                'type' => 'js',
                'code' => '<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "' . esc_attr( $gs[ 'st_pub_key' ] ) . '", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>'
            )
        );
        
        return $includes;
        
    }

    function settings( $values ){
        
?>

<h4><?php _e( 'Selected buttons', 'wpsr' ); ?></h4>
<button class="mini_section_select"><span class="dashicons dashicons-plus"></span> <?php _e( 'Click to open the list of buttons', 'wpsr' ); ?> <span class="dashicons dashicons-arrow-down fright"></span></button>

    <div class="mini_section">
        <p><?php _e( 'Drag and drop social buttons into the box below', 'wpsr' ); ?></p>
        <div class="mini_filters"><input type="text" class="list_search" data-list=".list_available" placeholder="<?php _e( 'Search', 'wpsr' ); ?> ..." /></div>
        <ul class="mini_btn_list list_available clearfix">
        <?php
            foreach( $this->sites as $site => $config ){
            echo '<li data-id="' . $site . '"><span>' . $config[ 'name' ] . '</span><i class="dashicons dashicons-trash item_action item_delete" title="' . __( 'Delete button', 'wpsr' ) . '"></i></li>';
            }
        ?>
        </ul>
    </div>

<ul class="mini_btn_list list_selected clearfix" data-callback="wpsr_st_process_list" data-input=".st_selected_list"><?php
    $saved = json_decode( base64_decode( $values[ 'selected_sites' ] ) );
    foreach( $saved as $site ){
        echo '<li data-id="' . $site . '"><span>' . $this->sites[ $site ][ 'name' ] . '</span><i class="dashicons dashicons-trash item_action item_delete" title="' . __( 'Delete button', 'wpsr' ) . '"></i></li>';
    }
?></ul>

<input type="hidden" name="o[selected_sites]" class="st_selected_list" value="<?php echo $values[ 'selected_sites' ]; ?>" />

<script>
wpsr_list_selector_init();
</script>

<h4>Settings</h4>

<?php
        
        $values = wp_parse_args( $values, $this->default_values );
        
        $section1 = array(
            array( __( 'Button type', 'wpsr' ), WPSR_Admin::field( 'select', array(
                'name' => 'o[type]',
                'value' => $values['type'],
                'list' => array(
                    'none' => __( '16px icons', 'wpsr' ),
                    'large' => __( '32px icons', 'wpsr' ),
                    'hcount' => __( 'Horizontal buttons', 'wpsr' ),
                    'vcount' => __( 'Vertical buttons', 'wpsr' ),
                )
            ))),
        );

        WPSR_Admin::build_table( $section1, '', '', true);

    }

    function validation( $values ){
        
        return $values;
        
    }
    
    function general_settings( $values ){
        
        $values = wp_parse_args( $values, WPSR_Lists::defaults( 'gsettings_sharethis' ) );
        
        $section1 = array(
            array( __( 'Publisher Key', 'wpsr' ), WPSR_Admin::field( 'text', array(
                'name' => 'st_pub_key',
                'value' => $values['st_pub_key'],
                'helper' => sprintf( __( 'Publisher key can be found <a href="%s" target="_blank">in this page</a>. Enter without brackets.','wpsr' ), 'https://www.sharethis.com/account/' )
            )))
        );

        WPSR_Admin::build_table( $section1, 'Sharethis settings');
    }
    
    function general_settings_validation( $values ){
        return $values;
    }
    
}

new wpsr_service_sharethis();

?>