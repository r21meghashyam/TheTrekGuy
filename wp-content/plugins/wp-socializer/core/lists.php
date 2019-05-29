<?php
/**
  * List of social media sites for social buttons, sharethis, default values for admin pages and list of external resoruces
  * 
  */

class WPSR_Lists{
    
    public static function init(){
        // Nothing to Init
    }
    
    public static function ext_res( $name = 'all' ){
        
        $res = array(
            'font-awesome' => 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
            'socializer-css' => 'https://cdn.rawgit.com/vaakash/socializer/01252dd4/css/socializer.min.css',
            'socializer-js' => 'https://cdn.rawgit.com/vaakash/socializer/01252dd4/js/socializer.min.js',
            'socializer-api' => 'https://cdn.rawgit.com/vaakash/socializer/01252dd4/misc/api.json',
            'wp-socializer-cl' => 'https://raw.githubusercontent.com/vaakash/aakash-web/master/misc/wp-socializer/changelog/',
            'jquery' => 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js',
            'help' => 'https://raw.githubusercontent.com/vaakash/aakash-web/master/misc/wp-socializer/help.html'
        );
        
        if( array_key_exists( $name, $res ) ){
            return $res[ $name ];
        }elseif( $name == 'all' ){
            return $res;
        }else{
            return '';
        }
        
    }
    
    public static function social_buttons(){
        
        $g_settings = get_option( 'wpsr_general_settings' );
        $g_settings = wp_parse_args( $g_settings, self::defaults( 'gsettings_socialbuttons' ) );
        
        return apply_filters( 'wpsr_mod_social_buttons_list', array(
            'addtofavorites' => array(
                'name' => 'Add to favorites',
                'title' => 'Add to favorites',
                'icon' => 'star',
                'link' => '#',
                'onclick' => 'socializer_addbookmark(event)',
                'options' => array(),
                'features' => array( 'for_share', 'requires_js' ),
                'colors' => array( '#F9A600' ),
            ),
            
            'behance' => array(
                'name' => 'Behance',
                'title' => __('', 'wpsr') . 'Behance',
                'icon' => 'behance',
                'link' => 'https://www.behance.net/',
                'options' => array(),
                'features' => array( 'for_profile' ),
                'colors' => array( '#1769ff' ),
            ),
            
            'bitbucket' => array(
                'name' => 'Bitbucket',
                'title' => __('', 'wpsr') . 'Bitbucket',
                'icon' => 'bitbucket',
                'link' => 'https://bitbucket.org/',
                'options' => array(),
                'features' => array( 'for_profile' ),
                'colors' => array( '#205081' ),
            ),
            
            'blogger' => array(
                'name' => 'Blogger',
                'title' => __('Post this on ', 'wpsr') . 'Blogger',
                'icon' => 'rss-square',
                'link' => 'https://www.blogger.com/blog-this.g?u={url}&n={title}&t={excerpt}',
                'options' => array(),
                'features' => array( 'for_share', 'for_tsb' ),
                'colors' => array( '#FF6501' ),
            ),
            
            'codepen' => array(
                'name' => 'CodePen',
                'title' => __('', 'wpsr') . 'CodePen',
                'icon' => 'codepen',
                'link' => 'https://codepen.io/',
                'options' => array(),
                'features' => array( 'for_profile' ),
                'colors' => array( '#000' ),
            ),
            
            'comments' => array(
                'name' => 'Comments',
                'title' => __('', 'wpsr') . 'Comments',
                'icon' => 'comments',
                'link' => '#',
                'onclick' => 'document.querySelector(\'' . $g_settings[ 'sb_comment_sec' ] . '\').scrollIntoView(true);',
                'options' => array(),
                'features' => array( 'internal', 'for_tsb' ),
                'colors' => array( '#333' ),
            ),
            
            'delicious' => array(
                'name' => 'Delicious',
                'title' => __('Post this on ', 'wpsr') . 'Delicious',
                'icon' => 'delicious',
                'link' => 'https://delicious.com/post?url={url}&title={title}&notes={excerpt}',
                'options' => array(),
                'features' => array( 'for_share' ),
                'colors' => array( '#3274D1' ),
            ),
            
            'deviantart' => array(
                'name' => 'DeviantArt',
                'title' => __('', 'wpsr') . 'DeviantArt',
                'icon' => 'deviantart',
                'link' => 'https://deviantart.com/',
                'options' => array(),
                'features' => array( 'for_profile' ),
                'colors' => array( '#475c4d' ),
            ),
            
            'digg' => array(
                'name' => 'Digg',
                'title' => __('Submit this to ', 'wpsr') . 'Digg',
                'icon' => 'digg',
                'link' => 'https://digg.com/submit?url={url}&title={title}',
                'options' => array(),
                'features' => array( 'for_share' ),
                'colors' => array( '#000' ),
            ),
            
            'dribbble' => array(
                'name' => 'Dribbble',
                'title' => __('', 'wpsr') . 'Dribble',
                'icon' => 'dribbble',
                'link' => 'https://dribbble.com/',
                'options' => array(),
                'features' => array( 'for_profile' ),
                'colors' => array( '#ea4c89' ),
            ),
            
            'email' => array(
                'name' => 'Email',
                'title' => __('Email this ', 'wpsr') . '',
                'icon' => 'envelope',
                'link' => 'mailto:?to=&subject={title}&body={excerpt}%20-%20{url}',
                'options' => array(),
                'features' => array( 'for_share', 'for_tsb' ),
                'colors' => array( '#000' ),
            ),
            
            'facebook' => array(
                'name' => 'Facebook',
                'title' => __('Share this on ', 'wpsr') . 'Facebook',
                'icon' => 'facebook',
                'link' => 'https://www.facebook.com/share.php?u={url}',
                'link_tsb' => 'https://www.facebook.com/share.php?u={url}&quote={excerpt}',
                'options' => array( 'count' ),
                'features' => array( 'for_share', 'for_profile', 'for_tsb' ),
                'colors' => array( '#3e5b98' ),
            ),
            
            'fbmessenger' => array(
                'name' => 'Facebook messenger',
                'title' => __('', 'wpsr') . 'Facebook messenger',
                'icon' => 'comment',
                'link' => 'fb-messenger://share?link={url}',
                'options' => array(),
                'features' => array( 'mobile_only' ),
                'colors' => array( '#2998ff' ),
            ),
            
            'flickr' => array(
                'name' => 'Flickr',
                'title' => __('', 'wpsr') . 'Flickr',
                'icon' => 'flickr',
                'link' => 'https://www.flickr.com',
                'options' => array(),
                'features' => array( 'for_profile' ),
                'colors' => array( '#1c9be9' ),
            ),
            
            'github' => array(
                'name' => 'Github',
                'title' => __('', 'wpsr') . 'Github',
                'icon' => 'github',
                'link' => 'https://www.github.com/',
                'options' => array(),
                'features' => array( 'for_profile' ),
                'colors' => array( '#333' ),
            ),
            
            'google' => array(
                'name' => 'Google',
                'title' => __('Bookmark this on ', 'wpsr') . 'Google','',
                'icon' => 'google',
                'link' => 'https://www.google.com/bookmarks/mark?op=edit&bkmk={url}&title={title}&annotation={excerpt}',
                'options' => array(),
                'features' => array( 'for_share', 'for_tsb' ),
                'colors' => array( '#3A7CEC' ),
            ),
            
            'googleplus' => array(
                'name' => 'Google Plus',
                'title' => __('Share this on ', 'wpsr') . 'Google Plus',
                'icon' => 'google-plus',
                'link' => 'https://plus.google.com/share?url={url}',
                'options' => array( 'count' ),
                'features' => array( 'for_share', 'for_profile' ),
                'colors' => array( '#DB483B' ),
            ),
            
            'hackernews' => array(
                'name' => 'Hacker News',
                'title' => __('Share this on ', 'wpsr') . 'HackerNews',
                'icon' => 'hacker-news',
                'link' => 'https://news.ycombinator.com/submitlink?u={url}&t={title}',
                'options' => array(),
                'features' => array( 'for_share' ),
                'colors' => array( '#FF6500' ),
            ),
            
            'instagram' => array(
                'name' => 'Instagram',
                'title' => __('', 'wpsr') . 'Instagram',
                'icon' => 'instagram',
                'link' => 'https://instagram.com',
                'options' => array(),
                'features' => array( 'for_profile' ),
                'colors' => array( '#0d3c5f' ),
            ),
            
            'linkedin' => array(
                'name' => 'LinkedIn',
                'title' => __('Add this to ', 'wpsr') . 'LinkedIn',
                'icon' => 'linkedin',
                'link' => 'https://www.linkedin.com/shareArticle?mini=true&url={url}&title={title}&summary={excerpt}',
                'options' => array( 'count' ),
                'features' => array( 'for_share', 'for_profile', 'for_tsb' ),
                'colors' => array( '#0274B3' ),
            ),
            
            'medium' => array(
                'name' => 'Medium',
                'title' => __('', 'wpsr') . 'Medium',
                'icon' => 'medium',
                'link' => 'https://medium.com',
                'options' => array(),
                'features' => array( 'for_profile' ),
                'colors' => array( '#02b875' ),
            ),
            
            'paypal' => array(
                'name' => 'PayPal',
                'title' => __('', 'wpsr') . 'PayPal',
                'icon' => 'paypal',
                'link' => 'https://paypal.com',
                'options' => array(),
                'features' => array( 'for_profile' ),
                'colors' => array( '#0070ba' ),
            ),
            
            'flickr' => array(
                'name' => 'Flickr',
                'title' => __('', 'wpsr') . 'Flickr',
                'icon' => 'flickr',
                'link' => 'https://www.flickr.com',
                'options' => array(),
                'features' => array( 'for_profile' ),
                'colors' => array( '#1c9be9' ),
            ),
            
            'pdf' => array(
                'name' => 'PDF',
                'title' => __('Convert to ', 'wpsr') . 'PDF',
                'icon' => 'file-pdf-o',
                'link' => 'https://www.printfriendly.com/print?url={url}',
                'options' => array(),
                'features' => array( 'for_share' ),
                'colors' => array( '#E61B2E' ),
            ),
            
            'pinterest' => array(
                'name' => 'Pinterest',
                'title' => __('Submit this to ', 'wpsr') . 'Pinterest',
                'icon' => 'pinterest',
                'link' => 'https://www.pinterest.com/pin/create/button/?url={url}&media={image}&description={excerpt}',
                'options' => array( 'count' ),
                'features' => array( 'for_share', 'for_profile', 'for_tsb' ),
                'colors' => array( '#CB2027' ),
            ),
            
            'pocket' => array(
                'name' => 'Pocket',
                'title' => __('Submit this to ', 'wpsr') . 'Pocket',
                'icon' => 'get-pocket',
                'link' => 'https://getpocket.com/save?url={url}&title={title}',
                'options' => array(),
                'features' => array( 'for_share' ),
                'colors' => array( '#EF4056' ),
            ),
            
            'print' => array(
                'name' => 'Print',
                'title' => __('Print this article ', 'wpsr') . '',
                'icon' => 'print',
                'link' => 'https://www.printfriendly.com/print?url={url}',
                'options' => array(),
                'features' => array( 'for_share' ),
                'colors' => array( '#6D9F00' ),
            ),
            
            'reddit' => array(
                'name' => 'Reddit',
                'title' => __('Submit this to ', 'wpsr') . 'Reddit',
                'icon' => 'reddit',
                'link' => 'https://reddit.com/submit?url={url}&title={title}',
                'options' => array(),
                'features' => array( 'for_share' ),
                'colors' => array( '#FF5600' ),
            ),
            
            'rss' => array(
                'name' => 'RSS',
                'title' => __('Subscribe to ', 'wpsr') . 'RSS',
                'icon' => 'rss',
                'link' => '{rss-url}',
                'options' => array(),
                'features' => array( 'internal' ),
                'colors' => array( '#FF7B0A' ),
            ),

            'shortlink' => array(
                'name' => 'Short link',
                'title' => __('', 'wpsr') . 'Short link',
                'icon' => 'link',
                'link' => '{s-url}',
                'onclick' => 'socializer_shortlink( event, this )',
                'options' => array(),
                'features' => array( 'internal', 'requires_js' ),
                'colors' => array( '#333' ),
            ),
            
            'snapchat' => array(
                'name' => 'Snapchat',
                'title' => __('', 'wpsr') . 'Snapchat',
                'icon' => 'snapchat',
                'link' => 'https://snapchat.com',
                'options' => array(),
                'features' => array( 'for_profile' ),
                'colors' => array( '#FFFC00' ),
            ),
            
            'soundcloud' => array(
                'name' => 'Soundcloud',
                'title' => __('', 'wpsr') . 'Soundcloud',
                'icon' => 'soundcloud',
                'link' => 'https://soundcloud.com/',
                'options' => array(),
                'features' => array( 'for_profile' ),
                'colors' => array( '#f50' ),
            ),
            
            'stackoverflow' => array(
                'name' => 'StackOverflow',
                'title' => __('', 'wpsr') . 'StackOverflow',
                'icon' => 'stack-overflow',
                'link' => 'https://stackoverflow.com/',
                'options' => array(),
                'features' => array( 'for_profile' ),
                'colors' => array( '#F48024' ),
            ),
            
            'stumbleupon' => array(
                'name' => 'StumbleUpon',
                'title' => __('Submit this to ', 'wpsr') . 'StumbleUpon',
                'icon' => 'stumbleupon',
                'link' => 'https://www.stumbleupon.com/submit?url={url}&title={title}',
                'options' => array( 'count' ),
                'features' => array( 'for_share' ),
                'colors' => array( '#EB4823' ),
            ),
            
            'quora' => array(
                'name' => 'Quora',
                'title' => __('', 'wpsr') . 'Quora',
                'icon' => 'quora',
                'link' => 'https://www.quora.com',
                'options' => array(),
                'features' => array( 'for_profile' ),
                'colors' => array( '#b92b27' ),
            ),
            
            'telegram' => array(
                'name' => 'Telegram',
                'title' => __('', 'wpsr') . 'Telegram',
                'icon' => 'telegram',
                'link' => 'https://telegram.me/share/url?url={url}&text={title}',
                'options' => array(),
                'features' => array( 'mobile_only' ),
                'colors' => array( '#179cde' ),
            ),
            
            'tumblr' => array(
                'name' => 'Tumblr',
                'title' => __('Share this on ', 'wpsr') . 'Tumblr',
                'icon' => 'tumblr',
                'link' => 'https://www.tumblr.com/share?v=3&u={url}&t={title}&s={excerpt}',
                'options' => array(),
                'features' => array( 'for_share', 'for_tsb' ),
                'colors' => array( '#314358' ),
            ),
            
            'twitter' => array(
                'name' => 'Twitter',
                'title' => __('Tweet this !', 'wpsr') . '',
                'icon' => 'twitter',
                'link' => 'https://twitter.com/home?status={title}%20-%20{s-url}%20{twitter-username}',
                'link_tsb' => 'https://twitter.com/home?status={excerpt}%20-%20{s-url}%20{twitter-username}',
                'options' => array(),
                'features' => array( 'for_share', 'for_profile', 'for_tsb' ),
                'colors' => array( '#4da7de' ),
            ),
            
            'vimeo' => array(
                'name' => 'Vimeo',
                'title' => __('', 'wpsr') . 'Vimeo',
                'icon' => 'vimeo',
                'link' => 'https://vimeo.com',
                'options' => array(),
                'features' => array( 'for_profile' ),
                'colors' => array( '#00ADEF' ),
            ),
            
            'vkontakte' => array(
                'name' => 'VKontakte',
                'title' => __('Share this on ', 'wpsr') . 'VKontakte',
                'icon' => 'vk',
                'link' => 'https://vk.com/share.php?url={url}&title={title}&description={excerpt}',
                'options' => array(),
                'features' => array( 'for_share', 'for_tsb' ),
                'colors' => array( '#4C75A3' ),
            ),
            
            'wechat' => array(
                'name' => 'wechat',
                'title' => __('', 'wpsr') . 'WeChat',
                'icon' => 'wechat',
                'link' => 'weixin://dl/chat?text={url}',
                'options' => array(),
                'features' => array( 'mobile_only' ),
                'colors' => array( '#7BB32E' ),
            ),
            
            'whatsapp' => array(
                'name' => 'WhatsApp',
                'title' => __('', 'wpsr') . 'WhatsApp',
                'icon' => 'whatsapp',
                'link' => 'whatsapp://send?text={url}',
                'options' => array(),
                'features' => array( 'mobile_only' ),
                'colors' => array( '#60b82d' ),
            ),
            
            'xing' => array(
                'name' => 'Xing',
                'title' => __('Share this on ', 'wpsr') . 'Xing',
                'icon' => 'xing',
                'link' => 'https://www.xing.com/app/user?op=share&url={url}',
                'options' => array(),
                'features' => array( 'for_share' ),
                'colors' => array( '#006567' ),
            ),
            
            'yahoomail' => array(
                'name' => 'Yahoo! Mail',
                'title' => __('Add this to ', 'wpsr') . 'Yahoo! Mail',
                'icon' => 'yahoo',
                'link' => 'https://compose.mail.yahoo.com/?body={excerpt}%20-%20{url}&subject={title}',
                'options' => array(),
                'features' => array( 'for_share', 'for_tsb' ),
                'colors' => array( '#4A00A1' ),
            ),
            
            'youtube' => array(
                'name' => 'Youtube',
                'title' => __('', 'wpsr') . 'Youtube',
                'icon' => 'youtube',
                'link' => 'https://youtube.com/',
                'options' => array(),
                'features' => array( 'for_profile' ),
                'colors' => array( '#cc181e' ),
            ),
            
        ));
        
    }
    
    public static function sharethis(){
        
        return apply_filters( 'wpsr_mod_sharethis_list', array(
            'fbsend' => array(
                'name' => 'Facebook Send'
            ),
            'plusone' => array(
                'name' => 'Google +1'
            ),
            'pinterestfollow' => array(
                'name' => 'Pinterest Follow'
            ),
            'twitterfollow' => array(
                'name' => 'Twitter Follow'
            ),
            'youtube' => array(
                'name' => 'Youtube Subscribe'
            ),
            'email' => array(
                'name' => 'Email'
            ),
            'pinterest' => array(
                'name' => 'Pinterest'
            ),
            'linkedin' => array(
                'name' => 'LinkedIn'
            ),
            'twitter' => array(
                'name' => 'Twitter'
            ),
            'facebook' => array(
                'name' => 'Facebook'
            ),
            'sharethis' => array(
                'name' => 'ShareThis'
            ),
            'googleplus' => array(
                'name' => 'Google +'
            ),
            'blogger' => array(
                'name' => 'Blogger'
            ),
            'buffer' => array(
                'name' => 'Buffer'
            ),
            'delicious' => array(
                'name' => 'Delicious'
            ),
            'digg' => array(
                'name' => 'Digg'
            ),
            'evernote' => array(
                'name' => 'Evernote'
            ),
            'flipboard' => array(
                'name' => 'Flipboard'
            ),
            'google' => array(
                'name' => 'Google'
            ),
            'google_bmarks' => array(
                'name' => 'Bookmarks'
            ),
            'instapaper' => array(
                'name' => 'Instapaper'
            ),
            'livejournal' => array(
                'name' => 'LiveJournal'
            ),
            'mail_ru' => array(
                'name' => 'mail.ru'
            ),
            'meneame' => array(
                'name' => 'Meneame'
            ),
            'odnoklassniki' => array(
                'name' => 'Odnoklassniki'
            ),
            'pocket' => array(
                'name' => 'Pocket'
            ),
            'print' => array(
                'name' => 'Print'
            ),
            'reddit' => array(
                'name' => 'Reddit'
            ),
            'stumbleupon' => array(
                'name' => 'StumbleUpon'
            ),
            'tumblr' => array(
                'name' => 'Tumblr'
            ),
            'vkontakte' => array(
                'name' => 'Vkontakte'
            ),
            'whatsapp' => array(
                'name' => 'WhatsApp'
            ),
            'xing' => array(
                'name' => 'Xing'
            ),
        ));
        
    }
    
    public static function lang_codes( $for = '' ){
        
        if( $for == 'google_plus' ){
            return apply_filters( 'wpsr_mod_googleplus_lang', array(
                'af' => 'Afrikaans', 'am' => 'Amharic', 'ar' => 'Arabic', 'eu' => 'Basque', 'bn' => 'Bengali', 'bg' => 'Bulgarian', 'ca' => 'Catalan', 'zh-HK' => 'Chinese (Hong Kong)', 'zh-CN' => 'Chinese (Simplified)', 'zh-TW' => 'Chinese (Traditional)', 'hr' => 'Croatian', 'cs' => 'Czech', 'da' => 'Danish', 'nl' => 'Dutch', 'en-GB' => 'English (UK)', 'en-US' => 'English (US)', 'et' => 'Estonian', 'fil' => 'Filipino', 'fi' => 'Finnish', 'fr' => 'French', 'fr-CA' => 'French (Canadian)', '' => '', 'gl' => 'Galician', 'de' => 'German', 'el' => 'Greek', 'gu' => 'Gujarati', 'iw' => 'Hebrew', 'hi' => 'Hindi', 'hu' => 'Hungarian', 'is' => 'Icelandic', 'id' => 'Indonesian', 'it' => 'Italian', 'ja' => 'Japanese', 'kn' => 'Kannada', 'ko' => 'Korean', 'lv' => 'Latvian', 'lt' => 'Lithuanian', 'ms' => 'Malay', 'ml' => 'Malayalam', 'mr' => 'Marathi', 'no' => 'Norwegian', 'fa' => 'Persian', 'pl' => 'Polish', '' => '', 'pt-BR' => 'Portuguese (Brazil)', 'pt-PT' => 'Portuguese (Portugal)', 'ro' => 'Romanian', 'ru' => 'Russian', 'sr' => 'Serbian', 'sk' => 'Slovak', 'sl' => 'Slovenian', 'es' => 'Spanish', 'es-419' => 'Spanish (Latin America)', 'sw' => 'Swahili', 'sv' => 'Swedish', 'ta' => 'Tamil', 'te' => 'Telugu', 'th' => 'Thai', 'tr' => 'Turkish', 'uk' => 'Ukrainian', 'ur' => 'Urdu', 'vi' => 'Vietnamese', 'zu' => 'Zulu'
            ));
        }
        
        if( $for == 'facebook' ){
            return apply_filters( 'wpsr_mod_facebook_lang', array(
                'af_ZA' => 'Afrikaans', 'ak_GH' => 'Akan', 'am_ET' => 'Amharic', 'ar_AR' => 'Arabic', 'as_IN' => 'Assamese', 'ay_BO' => 'Aymara', 'az_AZ' => 'Azerbaijani', 'be_BY' => 'Belarusian', 'bg_BG' => 'Bulgarian', 'bn_IN' => 'Bengali', 'bp_IN' => 'Bhojpuri', 'br_FR' => 'Breton', 'bs_BA' => 'Bosnian', 'ca_ES' => 'Catalan', 'cb_IQ' => 'Sorani Kurdish', 'ck_US' => 'Cherokee', 'co_FR' => 'Corsican', 'cs_CZ' => 'Czech', 'cx_PH' => 'Cebuano', 'cy_GB' => 'Welsh', 'da_DK' => 'Danish', 'de_DE' => 'German', 'el_GR' => 'Greek', 'en_GB' => 'English (UK)', 'en_PI' => 'English (Pirate)', 'en_UD' => 'English (Upside Down)', 'en_US' => 'English (US)', 'eo_EO' => 'Esperanto', 'es_ES' => 'Spanish (Spain)', 'es_LA' => 'Spanish', 'es_MX' => 'Spanish (Mexico)', 'et_EE' => 'Estonian', 'eu_ES' => 'Basque', 'fa_IR' => 'Persian', 'fb_LT' => 'Leet Speak', 'ff_NG' => 'Fula', 'fi_FI' => 'Finnish', 'fo_FO' => 'Faroese', 'fr_CA' => 'French (Canada)', 'fr_FR' => 'French (France)', 'fy_NL' => 'Frisian', 'ga_IE' => 'Irish', 'gl_ES' => 'Galician', 'gn_PY' => 'Guarani', 'gu_IN' => 'Gujarati', 'gx_GR' => 'Classical Greek', 'ha_NG' => 'Hausa', 'he_IL' => 'Hebrew', 'hi_IN' => 'Hindi', 'hr_HR' => 'Croatian', 'ht_HT' => 'Haitian Creole', 'hu_HU' => 'Hungarian', 'hy_AM' => 'Armenian', 'id_ID' => 'Indonesian', 'ig_NG' => 'Igbo', 'is_IS' => 'Icelandic', 'it_IT' => 'Italian', 'ja_JP' => 'Japanese', 'ja_KS' => 'Japanese (Kansai)', 'jv_ID' => 'Javanese', 'ka_GE' => 'Georgian', 'kk_KZ' => 'Kazakh', 'km_KH' => 'Khmer', 'kn_IN' => 'Kannada', 'ko_KR' => 'Korean', 'ks_IN' => 'Kashmiri', 'ku_TR' => 'Kurdish (Kurmanji)', 'ky_KG' => 'Kyrgyz', 'la_VA' => 'Latin', 'lg_UG' => 'Ganda', 'li_NL' => 'Limburgish', 'ln_CD' => 'Lingala', 'lo_LA' => 'Lao', 'lt_LT' => 'Lithuanian', 'lv_LV' => 'Latvian', 'mg_MG' => 'Malagasy', 'mi_NZ' => 'Māori', 'mk_MK' => 'Macedonian', 'ml_IN' => 'Malayalam', 'mn_MN' => 'Mongolian', 'mr_IN' => 'Marathi', 'ms_MY' => 'Malay', 'mt_MT' => 'Maltese', 'my_MM' => 'Burmese', 'nb_NO' => 'Norwegian (bokmal)', 'nd_ZW' => 'Northern Ndebele', 'ne_NP' => 'Nepali', 'nl_BE' => 'Dutch (België)', 'nl_NL' => 'Dutch', 'nn_NO' => 'Norwegian (nynorsk)', 'nr_ZA' => 'Southern Ndebele', 'ns_ZA' => 'Northern Sotho', 'ny_MW' => 'Chewa', 'or_IN' => 'Oriya', 'pa_IN' => 'Punjabi', 'pl_PL' => 'Polish', 'ps_AF' => 'Pashto', 'pt_BR' => 'Portuguese (Brazil)', 'pt_PT' => 'Portuguese (Portugal)', 'qc_GT' => 'Quiché', 'qu_PE' => 'Quechua', 'qz_MM' => 'Burmese (Zawgyi)', 'rm_CH' => 'Romansh', 'ro_RO' => 'Romanian', 'ru_RU' => 'Russian', 'rw_RW' => 'Kinyarwanda', 'sa_IN' => 'Sanskrit', 'sc_IT' => 'Sardinian', 'se_NO' => 'Northern Sámi', 'si_LK' => 'Sinhala', 'sk_SK' => 'Slovak', 'sl_SI' => 'Slovenian', 'sn_ZW' => 'Shona', 'so_SO' => 'Somali', 'sq_AL' => 'Albanian', 'sr_RS' => 'Serbian', 'ss_SZ' => 'Swazi', 'st_ZA' => 'Southern Sotho', 'sv_SE' => 'Swedish', 'sw_KE' => 'Swahili', 'sy_SY' => 'Syriac', 'sz_PL' => 'Silesian', 'ta_IN' => 'Tamil', 'te_IN' => 'Telugu', 'tg_TJ' => 'Tajik', 'th_TH' => 'Thai', 'tk_TM' => 'Turkmen', 'tl_PH' => 'Filipino', 'tl_ST' => 'Klingon', 'tn_BW' => 'Tswana', 'tr_TR' => 'Turkish', 'ts_ZA' => 'Tsonga', 'tt_RU' => 'Tatar', 'tz_MA' => 'Tamazight', 'uk_UA' => 'Ukrainian', 'ur_PK' => 'Urdu', 'uz_UZ' => 'Uzbek', 've_ZA' => 'Venda', 'vi_VN' => 'Vietnamese', 'wo_SN' => 'Wolof', 'xh_ZA' => 'Xhosa', 'yi_DE' => 'Yiddish', 'yo_NG' => 'Yoruba', 'zh_CN' => 'Simplified Chinese (China)', 'zh_HK' => 'Traditional Chinese (Hong Kong)', 'zh_TW' => 'Traditional Chinese (Taiwan)', 'zu_ZA' => 'Zulu', 'zz_TR' => 'Zazaki'
            ));
        }
        
        if( $for == 'linkedin' ){
            return apply_filters( 'wpsr_mod_linkedin_lang', array(
                'en_US' => 'English', 'ar_AE' => 'Arabic', 'zh_CN' => 'Chinese - Simplified', 'zh_TW' => 'Chinese - Traditional ', 'cs_CZ' => 'Czech', 'da_DK' => 'Danish', 'nl_NL' => 'Dutch', 'fr_FR' => 'French', 'de_DE' => 'German', 'in_ID' => 'Indonesian', 'it_IT' => 'Italian', 'ja_JP' => 'Japanese', 'ko_KR' => 'Korean', 'ms_MY' => 'Malay', 'no_NO' => 'Norwegian', 'pl_PL' => 'Polish', 'pt_BR' => 'Portuguese', 'ro_RO' => 'Romanian', 'ru_RU' => 'Russian', 'es_ES' => 'Spanish', 'sv_SE' => 'Swedish', 'tl_PH' => 'Tagalog', 'th_TH' => 'Thai', 'tr_TR' => 'Turkish'
            ));
        }
        
    }
    
    public static function defaults( $page ){
        
        if( $page == 'buttons' ){
            return array(
                'content' => 'eyIxIjp7InByb3BlcnRpZXMiOnt9LCJidXR0b25zIjpbXX19',
                'loc_rules' => array(
                    'type' => 'show_all',
                    'rule' => 'W10='
                ),
                'position' => 'below_posts',
                'in_excerpt' => 'show'
            );
        }
        
        if( $page == 'sharebar' ){
            return array(
                'ft_status' => 'ft_status',
                'buttons' => 'eyIxIjp7InByb3BlcnRpZXMiOnt9LCJidXR0b25zIjpbXX19',
                'type' => 'vertical',
                'vl_position' => 'wleft',
                'hl_position' => 'wbottom',
                'stick_element' => '',
                'theme' => 'simple',
                'vl_movement' => 'move',
                'css_class' => '',
                'offset' => '0',
                'bg_color' => '#ffffff',
                'border_color' => '#cccccc',
                'oc_color' => 'black',
                'loc_rules' => array(
                    'type' => 'show_all',
                    'rule' => 'W10='
                )
            );
        }
        
        if( $page == 'followbar' ){
            return array(
                'ft_status' => 'disable',
                'template' => 'W10=',
                'shape' => '',
                'size' => '32px',
                'text' => 'hide',
                'bg_color' => '',
                'icon_color' => '#ffffff',
                'orientation' => 'vertical',
                'position' => 'rm',
                'hover' => '',
                'pad' => 'pad',
                'title' => '',
                'open_popup' => 'no',
                'loc_rules' => array(
                    'type' => 'show_all',
                    'rule' => 'W10='
                )
            );
        }
        
        if( $page == 'text_sharebar' ){
            return array(
                'ft_status' => 'disable',
                'template' => 'W10=',
                'content' => '.entry-content',
                'size' => '32px',
                'bg_color' => '#333',
                'icon_color' => '#fff',
                'text_count' => '20',
                'loc_rules' => array(
                    'type' => 'show_all',
                    'rule' => 'W1tbInNpbmdsZSIsImVxdWFsIiwiIl1dLFtbInBhZ2UiLCJlcXVhbCIsIiJdXV0='
                )
            );
        }
        
        if( $page == 'mobile_sharebar' ){
            return array(
                'ft_status' => 'disable',
                'template' => 'W10=',
                'size' => '48px',
                'bg_color' => '',
                'icon_color' => '#ffffff',
                'pad' => 'pad',
                'on_desktop' => 'no',
                'loc_rules' => array(
                    'type' => 'show_all',
                    'rule' => 'W10='
                )
            );
        }
        
        if( $page == 'gsettings_twitter' ){
            return array(
                'twitter_username' => ''
            );
        }
        
        if( $page == 'gsettings_facebook' ){
            return array(
                'facebook_lang' => 'en_US'
            );
        }
        
        if( $page == 'gsettings_googleplus' ){
            return array(
                'googleplus_lang' => 'en-US'
            );
        }
        
        if( $page == 'gsettings_linkedin' ){
            return array(
                'linkedin_lang' => 'en_US'
            );
        }
        
        if( $page == 'gsettings_sharethis' ){
            return array(
                'st_pub_key' => ''
            );
        }
        
        if( $page == 'gsettings_socialbuttons' ){
            return array(
                'sb_comment_sec' => '#comments'
            );
        }
        
        if( $page == 'gsettings_misc' ){
            return array(
                'misc_additional_css' => ''
            );
        }
        
    }
    
}

WPSR_Lists::init();

?>