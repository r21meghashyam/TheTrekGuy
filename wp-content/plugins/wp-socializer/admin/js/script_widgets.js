(function($){
jQuery(document).ready(function(){
    
    var init = function(){
        loadColorPicker();
    }
    
    var loadColorPicker = function(){
        if( $.fn.wpColorPicker ){
            $( '.wpsr-color-picker' ).wpColorPicker();
        }
    }
    
    $(document).ajaxComplete(function(){
        loadColorPicker();
    });
    
    $( document ).on( 'change', '.wpsr_widget_selector', function(){
        $form = $(this).closest( 'form' );
        $form.find( '.wpsr_widget_wrap' ).fadeTo( 'fast', 0.3, function(){
            $form.find( '.widget-control-save' ).trigger( 'click' );
        });
    });
    
    $( document ).on( 'click', '.wpsr_ppe_widget_open', function(e){
        e.preventDefault();
        
        if( wpsr_ppe_ajax != '' ){
            
            wtmpl_cnt_id = $( this ).attr( 'data-wtmpl-cnt-id' );
            wtmpl_cnt = $( '#' + wtmpl_cnt_id ).val();
            wtmpl_prev_id = $( this ).attr( 'data-wtmpl-prev-id' );
            qstring = 'action=wpsr_widget_buttons&template=' + wtmpl_cnt + '&cnt_id=' + wtmpl_cnt_id + '&prev_id=' + wtmpl_prev_id;
            
            wpsr_ipopup_show( wpsr_ppe_ajax + '?' + qstring, '1200px', '80%' );
            
        }
    });
    
    $( document ).on( 'click', '.wpsr_ppe_fb_open', function(e){
        e.preventDefault();
        
        if( wpsr_ppe_ajax ){
            
            wtmpl_cnt_id = $( this ).attr( 'data-wtmpl-cnt-id' );
            wtmpl_cnt = $( '#' + wtmpl_cnt_id ).val();
            wtmpl_prev_id = $( this ).attr( 'data-wtmpl-prev-id' );
            qstring = 'action=wpsr_followbar_editor&template=' + wtmpl_cnt + '&cnt_id=' + wtmpl_cnt_id + '&prev_id=' + wtmpl_prev_id;
            
            wpsr_ipopup_show( wpsr_ppe_ajax + '?' + qstring, '500px', '80%' );
            
        }
    });
    
    // Initinitinitinitinit
    init();
    
});
})( jQuery );