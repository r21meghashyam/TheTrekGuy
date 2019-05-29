<?php
/**
  * HTML service for WP Socializer
  *
  */

class wpsr_service_html{
    
    function __construct(){
        
        WPSR_Services::register( 'html', array(
            'name' => 'Custom HTML',
            'icons' => WPSR_ADMIN_URL . '/images/icons/html.png',
            'desc' => __( 'Add custom HTML snippets like "heading" within the template', 'wpsr' ),
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
        
        $this->default_values = array(
            'html' => '<h3>' . __( 'Share this article', 'wpsr' ) . '</h3>',
            '_wrap_tag' => 0
        );
        
    }

    function output( $settings = array(), $page_info = array() ){
        
        $out = array();
        $settings = wp_parse_args( $settings, $this->default_values );
        
        $tags = array();
        $replace_with = array();
        foreach( $page_info as $id => $val ){
            array_push( $tags, '{' . $id . '}' );
            array_push( $replace_with, $val );
        }
        $final_html = str_replace( $tags, $replace_with, $settings[ 'html' ] );
        
        $out['html'] = balanceTags( $final_html );
        $out['includes'] = array();
        return $out;
        
    }
    
    function includes(){
        
        $includes = array();
        
        return $includes;
        
    }

    function settings( $values ){
        
        $values = wp_parse_args( $values, $this->default_values );
        
        echo '<p>' . __( 'Enter custom HTML below', 'wpsr' ) . '</p>';
        echo '<textarea class="custom_html_editor" name="o[html]" >' . $values[ 'html' ] . '</textarea>';
        
        echo '
<script>
wpsr_load_css( "wpsr_tbg_css", "' . WPSR_ADMIN_URL . 'js/trumbowyg/trumbowyg.min.css" );
wpsr_load_js( "wpsr_tbg_js", "' . WPSR_ADMIN_URL . 'js/trumbowyg/trumbowyg.min.js", function(){
    jQuery.trumbowyg.svgPath = "' . WPSR_ADMIN_URL . 'js/trumbowyg/icons.svg";
    jQuery( ".custom_html_editor" ).trumbowyg({
        autogrow: true,
        btns: [
            ["viewHTML"],
            ["formatting"],
            "btnGrp-semantic",
            ["superscript", "subscript"],
            ["link"],
            ["insertImage"],
            "btnGrp-justify",
            "btnGrp-lists",
            ["horizontalRule"],
            ["removeformat"]
        ]
    });
});
</script>
        ';
        
        echo '<h4>' . __( 'Note', 'wpsr' ) . ':</h4>';
        echo __( 'Placeholders <code>{url}</code> and <code>{title}</code> can be used in the HTML to replace them with post URL and title respectively', 'wpsr' );
        
    }

    function validation( $values ){
        $values[ '_wrap_tag' ] = 0;
        return $values;
        
    }
    
    
    function general_settings( $values ){
    
    }
    
    function general_settings_validation( $values ){
        return $values;
    }
    
}

new wpsr_service_html();

?>