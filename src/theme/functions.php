<?php

define( 'BEEZUP_VERSION', 1.0 );
define( 'BEEZUP_API_URL', 'https://api.beezup.com/v2/public/' );


/*-----------------------------------------------------------------------------------*/
/* Get BeezUP API data for networks pages
/*-----------------------------------------------------------------------------------*/
function beezup_get_data_transient($transientName, $url, $args = array()){
    $transient = get_site_transient( $transientName );
    if( $transient ) return $transient;
    
    $args['accept-encoding'] = 'gzip';
    $data = wp_safe_remote_get( BEEZUP_API_URL . $url, $args );
    if( is_wp_error( $data ) ) return;

    $result = wp_remote_retrieve_body( $data );
    if( is_wp_error( $result ) ) return;

    $result = json_decode( $result );
    set_site_transient( $transientName, $result, MONTH_IN_SECONDS );
    return $result;
}

function beezup_get_channels_by_type($channelsTypeIndex, $channelsForOneLang){
    foreach( $channelsForOneLang->channels as $channel ){
        foreach( $channelsTypeIndex->items as $type ){
            if( !property_exists($channel, 'types') ) return;
            if( $channel->types[0] !== $type->codeIdentifier ) continue;
            $channelsByTypeForOneLang[$type->codeIdentifier][] = $channel;
        }
    }

    return $channelsByTypeForOneLang;
}

function beezup_get_all_channels($channelsIndex, $currentLang){
    $channelsTypeIndex = beezup_get_data_transient( 'channels_type_index_' . $currentLang, 'lov/ChannelType', array('headers' => array('Accept-Language' => $currentLang)) );

    if( !$channelsIndex || !property_exists($channelsIndex, 'items') ) return;

    $allChannels = [];
    $channelsByType = get_site_transient('channels_by_type');

    foreach( $channelsIndex->items as $channel ){
        $code = $channel->codeIdentifier;
        $allChannels[$code] = beezup_get_data_transient( 'channels_' . $code, 'channels/' . $code );
        
        if( !$channelsByType || !property_exists($channelsTypeIndex, 'items') || !property_exists($allChannels[$code], 'channels')) continue;
        $channelsByType[$code] = beezup_get_channels_by_type( $channelsTypeIndex, $allChannels[$code] );
    }

    return [
        'allChannels' => $allChannels,
        'channelsByType' => $channelsByType
    ];
}

function beezup_get_data_to_display($isNetworkPage, $country, $type){
    $currentLang = get_field('lang2', 'options');

    $channelsIndex = beezup_get_data_transient( 'channels_index_' . $currentLang, 'lov/www_ChannelCountry', array('headers' => array('Accept-Language' => $currentLang)) );

    $allChannelsArray = beezup_get_all_channels($channelsIndex, $currentLang);
    $allChannels = $allChannelsArray['allChannels'];
    $channelsByType = $allChannelsArray['channelsByType'];
    $channelsToDisplay = [];

    $noChannels = false;

    if( $isNetworkPage ){
        if( isset($allChannels[$country]) && property_exists($allChannels[$country], 'channels') ){
            $channelsToDisplay = $allChannels[$country]->channels;
        }
    }elseif( $channelsByType && isset($channelsByType[$country]) ){
        if( isset($channelsByType[$country][$type]) ){
            $channelsToDisplay = $channelsByType[$country][$type];
        }else{
            $noChannels = true;
        }
    }

    if( $channelsToDisplay ){
        usort($channelsToDisplay, 'beezup_sort_by_name');
    }

    return [
        'channelsIndex' => $channelsIndex,
        'channelsToDisplay' => $channelsToDisplay,
        'channelsByType' => $channelsByType,
        'noChannels' => $noChannels
    ];
}

function beezup_ajax_get_data(){
    $fieldLang = get_field('lang', 'options');
    $defaultCountry = $fieldLang ? $fieldLang : 'FRA';
    $country = isset( $_GET['country'] ) ? $_GET['country'] : $defaultCountry;
    $isNetworkPage = isset( $_GET['isNetworkPage'] ) ? $_GET['isNetworkPage'] : '';
    $type = isset( $_GET['type'] ) ? $_GET['type'] : '';

    if( !session_id() ) session_start();
    $_SESSION['country'] = $country;
    
    $data = beezup_get_data_to_display($isNetworkPage, $country, $type);
    $channelsToDisplay = $data['channelsToDisplay'];
    $noChannels = $data['noChannels'];

    echo beezup_get_channels_to_display($channelsToDisplay, $noChannels); 

    die();
}
add_action( 'wp_ajax_beezup_ajax_get_data', 'beezup_ajax_get_data' );
add_action( 'wp_ajax_nopriv_beezup_ajax_get_data', 'beezup_ajax_get_data' );


/*-----------------------------------------------------------------------------------*/
/* Get BeezUP API HTML content for networks pages
/*-----------------------------------------------------------------------------------*/
function beezup_get_country_select($channelsIndex, $country){
    if( !$channelsIndex || !property_exists($channelsIndex, 'items') ) return;

    $output = '<div class="select"><select name="country" id="channelsCountrySelect">';
    $countries = $channelsIndex->items;

    usort($countries, 'beezup_sort_by_translationText');
    
    foreach( $countries as $channel ){
        $code = $channel->codeIdentifier;
        
        $output .= '<option value="' . $code . '"';
        if($code === $country){
            $output .= ' selected';
        }
        $output .= '>';
        $output .= $channel->translationText;
        $output .= '</option>';
    }

    $output .= ' </select></div>';
    return $output;
}

function beezup_get_sector_select(){
    $currentLang = get_field('lang2', 'options');

    $channelsSectorIndex = beezup_get_data_transient( 'channels_sector_index' . $currentLang, 'lov/ParamSector', array('headers' => array('Accept-Language' => $currentLang)) );

    if( !$channelsSectorIndex || !property_exists($channelsSectorIndex, 'items') ) return;

    $sectors = $channelsSectorIndex->items;
    usort($sectors, 'beezup_sort_by_translationText');

    $output = '<div class="select channels-select-sector"><select name="" id="channelsSectorSelect">';
    $output .= '<option value="all">' . __('All the sectors', 'beezup') . '</option>';
    
    foreach( $sectors as $sector ){
        $code = $sector->codeIdentifier;
        
        $output .= '<option value="' . $code . '"';
        $output .= '>';
        $output .= $sector->translationText;
        $output .= '</option>';
    }

    $output .= ' </select></div>';
    return $output;
}

function beezup_get_types_pages($channelsByType, $subPages, $country, $postID){
    if( !$channelsByType || !isset($channelsByType[$country]) || !$subPages ) return;
    
    $output = '';
    $count = 0;

    foreach( $subPages as $subPage ){
        $empty = true;
        foreach( $channelsByType as $channelsOneCountry){
            if( isset($channelsOneCountry[get_field('type', $subPage->ID)]) ){
                $empty = false;
            }
        }
        if( $empty ) continue;
        // if( !isset($channelsByType[$country][get_field('type', $subPage->ID)]) ) continue;

        $count ++;
        
        if( $postID === $subPage->ID ){
            $output .= '<li class="current"><span>0' . $count . '.</span> ' . $subPage->post_title . '<svg class="icon"><use xlink:href="#icon-check"></use></svg>';
        }else{
            $output .= '<li>';
            $output .= '<span>0' . $count . '.</span> ';
            $output .= '<a href="' . get_permalink($subPage->ID) . '?country=' . $country . '" class="link-arrow">' . $subPage->post_title . '</a>';
        }
        $output .= '</li>';
    }

    return $output;
}

// function beezup_ajax_get_types_pages(){
//     $fieldLang = get_field('lang', 'options');
//     $defaultCountry = $fieldLang ? $fieldLang : 'FRA';
//     $country = isset( $_GET['country'] ) ? $_GET['country'] : $defaultCountry;
//     $networkPage = isset( $_GET['networkPage'] ) ? $_GET['networkPage'] : '';
//     $postID = isset( $_GET['pageID'] ) ? $_GET['pageID'] : '';

//     echo beezup_get_types_pages($networkPage, $country, $postID); 

//     die();
// }
// add_action( 'wp_ajax_beezup_ajax_get_types_pages', 'beezup_ajax_get_types_pages' );
// add_action( 'wp_ajax_nopriv_beezup_ajax_get_types_pages', 'beezup_ajax_get_types_pages' );

function beezup_get_channels_to_display($channelsToDisplay, $noChannels){
    $output = '';

    if( $channelsToDisplay ){
        $output = '<ul class="galery channels-list">';

        foreach( $channelsToDisplay as $partner ){
            $name = $partner->name;
            $img = '<img src="' . $partner->logoUrl . '" alt="' . $name . '-flux-e-commerce-beezup">';
            $output .= '<li';
            $output .= ' data-sector="';
            if( property_exists($partner, 'sectors') && isset($partner->sectors) ){
                foreach($partner->sectors as $sector){
                    $output .= $sector . ',';
                }
            }
            $output .= '">';
            $output .= '<a href="' . $partner->homeUrl . '" title="' . $name . '" target="_blank">';
            $output .= '<span>' . $name . '</span>';
            $output .= $img;
            $output .= '</a></li>';
        }

        $output .= '</ul>';
    }else{
        
        if( $noChannels ){
            $output = '<p class="channels-error"><svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-error"></use></svg>' . __("There are no channels of this type in this country.", 'beezup') . '</p>';
        }else{
            $output = '<p class="channels-error"><svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-error"></use></svg>' . __("Channels can't be displayed at this time. Please come back later!", 'beezup') . '</p>';
        }

    }

    return $output;    
}


/*-----------------------------------------------------------------------------------*/
/* General
/*-----------------------------------------------------------------------------------*/
// Plugins updates
add_filter( 'auto_update_plugin', '__return_true' );

// Theme support
add_theme_support( 'html5', array(
    'comment-list',
    'comment-form',
    'search-form',
    'gallery',
    'caption',
    'widgets'
) );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'title-tag' );

remove_post_type_support( 'post', 'editor' );

// Admin bar
show_admin_bar(false);

// Disable Tags
function beezup_unregister_tags(){
    unregister_taxonomy_for_object_type('post_tag', 'post');
}
add_action( 'init', 'beezup_unregister_tags' );

// Convert accent
function beezup_convert_accent($string){
    $trans = array('é' => 'e', 'É' => 'E', '&eacute;' => 'e', '&aacute;' => 'a', 'á' => 'a', 'À' => 'A', '&iacute;' => 'i', 'í' => 'i', 'ó' => 'o', '&oacute;' => 'o', '&uacute;' => 'u', 'ú' => 'u', '&ouml;' => 'u', 'ü' => 'u');

    return strtr($string, $trans);    
}

// Sort object in an array by their name properties
function beezup_sort_by_name($a, $b){
    $a = beezup_convert_accent($a->name);
    $b = beezup_convert_accent($b->name);

    return strcasecmp($a, $b);
}

// Sort object in an array by their translationText properties
function beezup_sort_by_translationText($a, $b){
    $a = beezup_convert_accent($a->translationText);
    $b = beezup_convert_accent($b->translationText);

    return strcasecmp($a, $b);
}


/*-----------------------------------------------------------------------------------*/
/* Clean WordPress head and remove some stuff for security
/*-----------------------------------------------------------------------------------*/
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
add_filter( 'emoji_svg_url', '__return_false' );

// remove api rest links
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

// remove login errors
add_filter( 'login_errors', create_function('$a', "return null;") );


/*-----------------------------------------------------------------------------------*/
/* Admin
/*-----------------------------------------------------------------------------------*/
// Remove some useless admin stuff
function beezup_remove_menus(){
    remove_submenu_page( 'themes.php', 'themes.php' );
    remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'beezup_remove_menus', 999 );
function beezup_remove_top_menus( $wp_admin_bar ){
    $wp_admin_bar->remove_node( 'wp-logo' );
}
add_action( 'admin_bar_menu', 'beezup_remove_top_menus', 999 );

// Enlever le lien par défaut autour des images
function beezup_imagelink_setup(){
	if( get_option( 'image_default_link_type' ) !== 'none' ) update_option('image_default_link_type', 'none');
}
add_action( 'admin_init', 'beezup_imagelink_setup' );

// Enlever les <p> autour des images
function beezup_remove_p_around_images($content){
    return preg_replace( '/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content );
}
add_filter( 'the_content', 'beezup_remove_p_around_images' );

// Allow svg in media library
function beezup_mime_types($mimes){
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'beezup_mime_types' );

// Custom posts in the dashboard
function beezup_right_now_custom_post(){
    $post_types = get_post_types( array( '_builtin' => false ) , 'objects' , 'and' );
    foreach( $post_types as $post_type ){
        $cpt_name = $post_type->name;
        if( $cpt_name !== 'acf-field-group' && $cpt_name !== 'acf-field' && $cpt_name !== 'omapi' ){
            $num_posts = wp_count_posts($post_type->name);
            $num = number_format_i18n($num_posts->publish);
            $text = _n($post_type->labels->name, $post_type->labels->name , intval($num_posts->publish));
            echo '<li class="'. $cpt_name .'-count"><tr><a class="'.$cpt_name.'" href="edit.php?post_type='.$cpt_name.'"><td></td>' . $num . ' <td>' . $text . '</td></a></tr></li>';
        }
    }
}
add_action( 'dashboard_glance_items', 'beezup_right_now_custom_post' );

// Add new styles to wysiwyg
function beezup_button($buttons){
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
add_filter( 'mce_buttons_2', 'beezup_button' );
function beezup_init_editor_styles(){
    add_editor_style();
}
add_action( 'after_setup_theme', 'beezup_init_editor_styles' );

// Customize a bit the wysiwyg editor
function beezup_mce_before_init( $styles ){
    $style_formats = array(
        array(
            'title' => 'Texte plus gros',
            'selector' => 'p',
            'classes' => 'big'
        ),
        array(
            'title' => 'Bloc étoile',
            'selector' => 'p',
            'classes' => 'star'
        ),
        array(
            'title' => 'Bloc bleu',
            'selector' => 'p',
            'classes' => 'block-full'
        ),
        array(
            'title' => 'Image pleine largeur',
            'selector' => 'img',
            'classes' => 'wide'
        ),
        array(
            'title' => 'Lien fléché',
            'selector' => 'a',
            'classes' => 'link-arrow'
        ),
        array(
            'title' => 'Bouton',
            'selector' => 'a',
            'classes' => 'btn'
        ),
        array(
            'title' => 'Bouton fléché',
            'selector' => 'a',
            'classes' => 'btn btn-arrow-bg'
        )
    );
    $styles['style_formats'] = json_encode( $style_formats );
    // Remove h1 and code
    $styles['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6';
    // Let only the colors you want
    $styles['textcolor_map'] = '[' . "'000000', 'Noir', 'ffffff', 'Blanc', '262729', 'Texte', '009ae1', 'Principale', 'e6006c', 'Secondaire'" . ']';
    return $styles;
}
add_filter( 'tiny_mce_before_init', 'beezup_mce_before_init' );

// Add Options Page
if( function_exists('acf_add_options_page') ){
    $optionsMainPage = acf_add_options_page( array(
        'position'   => 2,
        'page_title' => 'Theme General Options',
        'menu_title' => 'Theme Options',
        'redirect'   => false
    ) );

    // acf_add_options_sub_page( array(
    //     'page_title'    => 'Footer Settings',
    //     'menu_title'    => 'Footer',
    //     'parent_slug'   => $optionsMainPage['menu_slug'],
    // ) );
}

// Add tags in acf fields
function beezup_acf_load_value( $value, $field, $post_id ){
    if( is_admin() ) return $value;
    
    $value = str_replace( '[small]', '<span class="small">', str_replace( '[/small]', '</span>', $value ) );
    $value = str_replace( '[blue]', '<span class="blue">', str_replace( '[/blue]', '</span>', $value ) );
    return $value;
}
add_filter('acf/load_value', 'beezup_acf_load_value', 10, 3);


/*-----------------------------------------------------------------------------------*/
/* Menus
/*-----------------------------------------------------------------------------------*/
register_nav_menus( array(
    'primary' => 'Primary Menu',
    'secondary' => 'Secondary Menu',
    'footer' => 'Footer Menu'
) );

// Cleanup WP Menu html
function beezup_css_attributes_filter($var){
    return is_array( $var ) ? array_intersect( $var, array('current-menu-item', 'current_page_parent', 'current-page-ancestor', 'hide-desktop') ) : '';
}
add_filter( 'nav_menu_css_class', 'beezup_css_attributes_filter' );

// Add a div around submenus
class Child_Wrap extends Walker_Nav_Menu{
    function start_lvl(&$output, $depth = 0, $args = array()){
        $indent = str_repeat('\t', $depth);
        $output .= "\n$indent<div class=\"sub-menu\"><ul>\n";
    }
    function end_lvl(&$output, $depth = 0, $args = array()){
        $indent = str_repeat('\t', $depth);
        $output .= "$indent</ul></div>\n";
    }
} 


/*-----------------------------------------------------------------------------------*/
/* Sidebar & Widgets
/*-----------------------------------------------------------------------------------*/
// function beezup_register_sidebars(){
// 	register_sidebar( array(
// 		'id' => 'sidebar',
// 		'name' => 'Sidebar',
// 		'description' => 'Take it on the side...',
// 		'before_widget' => '',
// 		'after_widget' => '',
// 		'before_title' => '',
// 		'after_title' => '',
// 		'empty_title'=> ''
// 	) );
// }
// add_action( 'widgets_init', 'beezup_register_sidebars' );

// // Deregister default widgets
// function beezup_unregister_default_widgets(){
//     unregister_widget( 'WP_Widget_Pages' );
//     unregister_widget( 'WP_Widget_Calendar' );
//     unregister_widget( 'WP_Widget_Archives' );
//     unregister_widget( 'WP_Widget_Links' );
//     unregister_widget( 'WP_Widget_Meta' );
//     unregister_widget( 'WP_Widget_Search' );
//     unregister_widget( 'WP_Widget_Text' );
//     unregister_widget( 'WP_Widget_Categories' );
//     unregister_widget( 'WP_Widget_Recent_Posts' );
//     unregister_widget( 'WP_Widget_Recent_Comments' );
//     unregister_widget( 'WP_Widget_RSS' );
//     unregister_widget( 'WP_Widget_Tag_Cloud' );
//     unregister_widget( 'WP_Nav_Menu_Widget' );
// }
// add_action( 'widgets_init', 'beezup_unregister_default_widgets' );


/*-----------------------------------------------------------------------------------*/
/* Blog
/*-----------------------------------------------------------------------------------*/
function beezup_search_filter($query){
    if($query->is_main_query() && $query->is_search){
        $query->set('post_type', 'post');
    }
    return $query;
}
add_filter( 'pre_get_posts', 'beezup_search_filter' );


/*-----------------------------------------------------------------------------------*/
/* MLP Language Switcher
/*-----------------------------------------------------------------------------------*/
function beezup_mlp_navigation(){
    $api = apply_filters( 'mlp_language_api', NULL );
    if( ! is_a( $api, 'Mlp_Language_Api_Interface' ) ){
        return '';
    }

    $translations_args = array(
        'strict'       => FALSE,
        'include_base' => TRUE,
    );

    $translations = $api->get_translations( $translations_args );
    if( empty( $translations ) ){
        return '';
    }

    $items = array();

    foreach( $translations as $site_id => $translation ){
        $url = $translation->get_remote_url();
        if( empty( $url ) ){
            continue;
        }

        $language = $translation->get_language();

        $items[ $site_id ] = array(
            'url'      => $url,
            'http'     => $language->get_name( 'http' ),
            'name'     => $language->get_name( 'text' ),
            'priority' => $language->get_priority(),
            'icon'     => (string) $translation->get_icon_url(),
        );
    }
    ksort( $items );
    $before = '<div class="mlp-lang-switcher" id="header-lang-switcher">';
    $after = '</div>';

    $otherLangItems = array();

    foreach( $items as $site_id => $item ){
        $text = $item[ 'name' ];

        $img = '';

        if( get_current_blog_id() === $site_id ){
            $currentLangItem = '<span id="current-language" class="current-language-nav-item"><span class="current-language-item">' . $img . esc_html( $text ) . '</span><svg class="icon icon-arrow-down"><use xlink:href="#icon-arrow-down"></use></svg></span>';
        }else{
            $otherLangItem = sprintf(
                '<li><a rel="alternate" hreflang="%1$s" href="%2$s">%3$s%4$s</a></li>',
                esc_attr( $item['http'] ),
                esc_url( $item[ 'url' ] ),
                $img,
                esc_html( $text )
            );
            array_push($otherLangItems, $otherLangItem);
        }
    }

    return $before . $currentLangItem . '<ul id="otherLanguage" class="other-language-items">' . join( '', $otherLangItems ) . '</ul>' . $after;
}

function beezup_mlp_footer_lang(){
    $api = apply_filters( 'mlp_language_api', NULL );
    if( ! is_a( $api, 'Mlp_Language_Api_Interface' ) ){
        return '';
    }

    $translations_args = array(
        'strict'       => FALSE,
        'include_base' => TRUE,
    );

    $translations = $api->get_translations( $translations_args );
    if( empty( $translations ) ){
        return '';
    }

    $items = array();

    foreach( $translations as $site_id => $translation ){
        $url = $translation->get_remote_url();
        if( empty( $url ) ){
            continue;
        }

        $language = $translation->get_language();

        $items[ $site_id ] = array(
            'url'      => $url,
            'native'   => $language->get_name( 'native_name' ),
            'http'     => $language->get_name( 'http' ),
            'name'     => $language->get_name( 'text' ),
            'priority' => $language->get_priority(),
            'icon'     => (string) $translation->get_icon_url(),
        );
    }
    ksort( $items );

    $otherLangItems = array();

    foreach( $items as $site_id => $item ){

        $text = $item[ 'native' ];

        $img = '';

        if( get_current_blog_id() === $site_id ){
            $currentLangItem = '';
        }else{
            $otherLangItem = sprintf(
                '<li><a rel="alternate" hreflang="%1$s" href="%2$s">Beezup %3$s%4$s</a></li>',

                esc_attr( $item['http'] ),
                esc_url( $item[ 'url' ] ),
                $img,
                esc_html( $text )
            );
            array_push($otherLangItems, $otherLangItem);
        }
    }

    return "<ul>" . join( '', $otherLangItems ) . "</ul>";
}

function beezup_mlp_href_US(){
    $api = apply_filters( 'mlp_language_api', NULL );
    if( ! is_a( $api, 'Mlp_Language_Api_Interface' ) ){
        return '';
    }

    $translations_args = array(
        'strict'       => FALSE,
        'include_base' => TRUE,
    );

    $translations = $api->get_translations( $translations_args );
    if( empty( $translations ) ){
        return '';
    }

    $items = array();

    foreach( $translations as $site_id => $translation ){
        $url = $translation->get_remote_url();
        if( empty( $url ) ){
            continue;
        }

        $language = $translation->get_language();

        $items[ $site_id ] = array(
            'url'      => $url,
            'http'     => $language->get_name( 'http' )
        );
    }

    $hrefLinkUS = '';
    foreach( $items as $site_id => $item ){
        if( $item['http'] == 'en-GB'){
            $hrefLinkUS = '<link rel="alternate" hreflang="en-US" href="' . esc_attr( $item["url"] ) . '">';
        }
    }

    echo $hrefLinkUS;
}


/*-----------------------------------------------------------------------------------*/
/* Yoast breadcrumbs
/*-----------------------------------------------------------------------------------*/
// include_once( get_template_directory() . '/functions/schemaorg_breadcrumbs.php' );

// function beezup_instantiate_breadcrumbs_class(){
//     global $schemaorg_breadcrumbs;
//     $schemaorg_breadcrumbs = null;

//     if( function_exists( 'yoast_breadcrumb' ) && class_exists( 'SchemaOrg_Breadcrumbs' ) ){
//         $schemaorg_breadcrumbs = new SchemaOrg_Breadcrumbs();
//     }
// }
// add_action( 'after_setup_theme', 'beezup_instantiate_breadcrumbs_class' );


/*-----------------------------------------------------------------------------------*/
/* WP Rocket
/*-----------------------------------------------------------------------------------*/
function beez_cookies($cookies){
    $cookies[] = 'beez-cookies';
    return $cookies;
}
add_filter( 'rocket_cache_dynamic_cookies', 'beez_cookies' );


/*-----------------------------------------------------------------------------------*/
/* Enqueue Styles and Scripts
/*-----------------------------------------------------------------------------------*/
// Add defer attr to scripts
function beezup_defer_attr($tag, $handle){
    $scriptsToDefer = array('sendinblue-scripts', 'calendly-scripts');
   
    foreach( $scriptsToDefer as $script ){
        if( $script === $handle ){
            return str_replace( ' src', ' defer src', $tag );
        }
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'beezup_defer_attr', 10, 2 );

// Register and enqueue styles and scripts
function beezup_scripts(){
    // CSS
	wp_enqueue_style( 'beezup-style', get_template_directory_uri() . '/css/main.css', array(), BEEZUP_VERSION );

	// JS
	wp_deregister_script( 'jquery' );
    wp_deregister_script( 'wp-embed' );
	
    wp_register_script( 'beezup-scripts', get_template_directory_uri() . '/js/main.js', array(), BEEZUP_VERSION, true );
    wp_register_script( 'sendinblue-scripts', 'https://my.sendinblue.com/public/theme/version4/assets/js/src/subscribe-validate.js', array(), null, true );
    wp_register_script( 'calendly-scripts', 'https://calendly.com/assets/external/widget.js', array(), null, true );
    
    wp_enqueue_script( 'beezup-scripts');
    wp_enqueue_script( 'sendinblue-scripts');
    wp_enqueue_script( 'calendly-scripts');

    // Pass some data to JS for networks page and form pages
    global $post;
    $networkPage = get_field('networkPage', 'options');
    $isNetworkPage = $post->ID === $networkPage;

    $isFormPage = is_page_template( 'contact.php' ) || is_page_template( 'tarifs.php' );

    wp_localize_script( 'beezup-scripts', 'wp', array(
        'adminAjax' => site_url( '/wp-admin/admin-ajax.php' ),
        'isNetworkPage' => $isNetworkPage,
        'type' => get_field('type', $post->ID),
        'noChannels' => '<svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-error"></use></svg>' . __('There are no channels of this sector in this country', 'beezup'),
        'noChannelsType' => '<svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-error"></use></svg>' . __('There are no channels of this sector and this type in this country', 'beezup'),
        'noChannelsSearch' => '<svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-error"></use></svg>' . __('There no channels matching your search', 'beezup'),

        'isFormPage' => $isFormPage,
        'contactIds' => array('sales' => get_field('contactId', 'options'), 'support' => get_field('contactId2', 'options'), 'other' => get_field('contactId3', 'options'), 'accounting' => get_field('contactId4', 'options')),
        'contactLists' => array('sales' => get_field('contactLists', 'options'), 'support' => get_field('contactLists2', 'options'), 'other' => get_field('contactLists3', 'options'), 'accounting' => get_field('contactLists4', 'options'))
    ) );
    
}
add_action( 'wp_enqueue_scripts', 'beezup_scripts' );

// Add inline scripts to wp-footer
function beezup_footer(){ ?>
    <!-- SendinBlue Ajax Form validation -->
    <script>
        var sib_prefix = 'sib', sib_dateformat = 'dd-mm-yyyy';
    </script>
<?php }
add_action( 'wp_footer', 'beezup_footer');

?>
