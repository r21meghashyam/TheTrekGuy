window.wpsr_helpers = {
    addClass: function( ele, className ){
        if ( ele.classList )
          ele.classList.add( className );
        else
          ele.className += ' ' + className;
    },
    
    removeClass: function( ele, className ){
        if (ele.classList)
            ele.classList.remove(className);
        else
            ele.className = ele.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
    },
    
    popup: function( url, target, w, h ){
        var left = ( screen.width/2 )-( w/2 );
        var top = ( screen.height/2 )-( h/2 );
        return window.open( url, target, 'toolbar=no,location=no,menubar=no,scrollbars=yes,width='+w+',height='+h+',top='+top+',left='+left );
    }
    
};

document.addEventListener( 'DOMContentLoaded', function(){
    
    // Socializer links
    scr_links = document.querySelectorAll( '.socializer.sr-popup a' );
    
    for( i=0; i<scr_links.length; i++ ){
        var atag = scr_links[i];
        atag.addEventListener( 'click', function(e){
            var href = this.getAttribute( 'href' );
            if( !( href == '#' || this.hasAttribute( 'onclick' ) ) ){
                wpsr_helpers.popup( href, '_blank', 800, 500 );
            }
            e.preventDefault();
        });
    }
    
    // Sharebar
    the_sb = document.querySelector( '.wpsr-sharebar' );
    
    if( the_sb ){
        
        var hide_class = 'wpsr-sb-hide';
        
        var sb_resize = function(){
            vlsb = document.querySelector( '.wpsr-sb-vl-scontent' );
            if( vlsb ){
                stick = vlsb.getAttribute( 'data-stickto' );
                stick_ele = document.querySelector( stick );
                if( stick_ele ){
                    vlsb.style.left = stick_ele.offsetLeft + 'px';
                }
            }
            
            if( the_sb && window.innerWidth <= 800 ){
                wpsr_helpers.addClass( the_sb, hide_class );
            }
        }
        
        sb_resize();
        window.addEventListener( 'resize', sb_resize );
        
        sb_close_btn = the_sb.querySelector( '.wpsr-sb-close' );
        sb_close_btn.addEventListener( 'click', function(){
            if( the_sb.classList.contains( hide_class ) ){
                wpsr_helpers.removeClass( the_sb, hide_class );
            }else{
                wpsr_helpers.addClass( the_sb, hide_class );
            }
        });
    }
    
    // Text sharebar
    tsb = document.querySelector( '.wpsr-text-sb' );
    
    if( tsb ){
        
        window.wpsr_tsb = {
            stext: '',
            startx: 0,
            starty: 0
        };
        
        var tsb_attr = {
            ptitle: tsb.getAttribute( 'data-title' ),
            purl: tsb.getAttribute( 'data-url' ),
            psurl: tsb.getAttribute( 'data-surl' ),
            ptuname: tsb.getAttribute( 'data-tuname' ),
            cnt_sel: tsb.getAttribute( 'data-content' ),
            word_count: tsb.getAttribute( 'data-tcount' ) 
        };
        
        var get_selection_text = function() {
            var text = '';
            if( window.getSelection ){
                text = window.getSelection().toString();
            }else if( document.selection && document.selection.type != 'Control' ){
                text = document.selection.createRange().text;
            }
            return text;
        };
        
        var tsb_show = function( x, y ){
            tsb.style.left = x + 'px';
            tsb.style.top = y + 'px';
            wpsr_helpers.addClass( tsb, 'wpsr-tsb-active' );
        };
        
        var tsb_hide = function(){
            wpsr_helpers.removeClass( tsb, 'wpsr-tsb-active' );
        };
        
        var sel_link_text = function(){
            var sel_text = wpsr_tsb.stext;
            var wcount = parseInt( tsb_attr.word_count );
            
            if( wcount == 0 ){
                return sel_text;
            }else{
                return sel_text.split( ' ' ).slice( 0, wcount ).join( ' ' );
            }
        };
        
        var replace_link = function( link ){
            var to_replace = {
                '{title}': tsb_attr.ptitle,
                '{url}': tsb_attr.purl,
                '{s-url}': tsb_attr.psurl,
                '{twitter-username}': tsb_attr.ptuname,
                '{excerpt}': sel_link_text()
            };
            
            for( var key in to_replace ){
                if( to_replace.hasOwnProperty( key ) ){
                    link = link.replace( RegExp( key, "g" ), to_replace[ key ] );
                }
            }
            
            return link;
            
        }
        
        if( tsb_attr.cnt_sel != '' ){
            
            var tsb_cnt_sel = tsb_attr.cnt_sel.replace( /[\[\]<>"'/\\=&%]/g,'' );
            var tsb_content = document.querySelectorAll( tsb_cnt_sel );
            
            for( var i = 0; i < tsb_content.length; i++ ){
                
                var content = tsb_content[i];
                
                content.addEventListener( 'mousedown', function(e){
                    wpsr_tsb.startx = e.pageX;
                    wpsr_tsb.starty = e.pageY;
                });
                
                content.addEventListener( 'mouseup', function(e){
                    var sel_text = get_selection_text();
                    
                    if( sel_text != '' ){
                        
                        tsb_x = ( e.pageX + parseInt( wpsr_tsb.startx ) )/2;
                        tsb_y = Math.min( wpsr_tsb.starty, e.pageY );
                        
                        if( sel_text != wpsr_tsb.stext ){
                            tsb_show( tsb_x, tsb_y );
                            wpsr_tsb.stext = sel_text;
                        }else{
                            tsb_hide();
                        }
                        
                    }else{
                        
                        tsb_hide();
                        
                    }
                });
            }
        }
        
        document.body.addEventListener( 'mousedown', function(e){
            tsb_hide();
        });
        
        tsb.addEventListener( 'mousedown', function(e){
            e.stopPropagation();
        });
        
        var atags = tsb.querySelectorAll( 'a' );
        for( var i = 0; i < atags.length; i++ ){
            var atag = atags[i];
            atag.addEventListener( 'click', function(e){
                var alink = this.getAttribute( 'data-link' );
                
                if( alink != '#' ){
                    rep_link = replace_link( alink );
                    wpsr_helpers.popup( rep_link, 800, 500 );
                }
                
                e.preventDefault();
            });
        }
        
    }
    
    // Mobile sharebar
    msb = document.querySelector( '.wpsr-mobile-sb' );
    if( msb ){
        var lastScrollTop = 0;
        
        window.addEventListener( "scroll", function(){
            var st = window.pageYOffset || document.documentElement.scrollTop;
            if ( st > lastScrollTop ){
               wpsr_helpers.addClass( msb, 'wpsr-msb-hide' );
            } else {
               wpsr_helpers.removeClass( msb, 'wpsr-msb-hide' );
            }
            lastScrollTop = st;
        }, false );
        
    }
    
});

function socializer_addbookmark( e ){
    var ua = navigator.userAgent.toLowerCase();
    var isMac = (ua.indexOf('mac') != -1), str = '';
    e.preventDefault();
    str = (isMac ? 'Command/Cmd' : 'CTRL') + ' + D';
    alert('Press ' + str + ' to bookmark this page');
}

function socializer_shortlink( e, t ){
    e.preventDefault();
    link = t.getAttribute( 'href' );
    if( link != '#' )
        prompt( 'Short link', link );
}