<?php

define( 'BEEZUP_VERSION', 1.0 );


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


/*-----------------------------------------------------------------------------------*/
/* Clean WordPress head and remove some stuff for security
/*-----------------------------------------------------------------------------------*/
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
add_filter( 'emoji_svg_url', '__return_false' );

// remove api rest links
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

// remove comment author class
function beezup_remove_comment_author_class( $classes ){
	foreach( $classes as $key => $class ){
		if( strstr($class, 'comment-author-') ) unset( $classes[$key] );
	}
	return $classes;
}
add_filter( 'comment_class' , 'beezup_remove_comment_author_class' );

// remove login errors
add_filter( 'login_errors', create_function('$a', "return null;") );


/*-----------------------------------------------------------------------------------*/
/* Admin
/*-----------------------------------------------------------------------------------*/
// Remove some useless admin stuff
function beezup_remove_submenus(){
    remove_submenu_page( 'themes.php', 'themes.php' );
}
add_action( 'admin_menu', 'beezup_remove_submenus', 999 );
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
function beezup_right_now_custom_post() {
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
    return is_array( $var ) ? array_intersect( $var, array('current-menu-item', 'current_page_parent') ) : '';
}
add_filter( 'nav_menu_css_class', 'beezup_css_attributes_filter' );


/*-----------------------------------------------------------------------------------*/
/* Sidebar & Widgets
/*-----------------------------------------------------------------------------------*/
function beezup_register_sidebars(){
	register_sidebar( array(
		'id' => 'sidebar',
		'name' => 'Sidebar',
		'description' => 'Take it on the side...',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
		'empty_title'=> ''
	) );
}
add_action( 'widgets_init', 'beezup_register_sidebars' );

// Deregister default widgets
function beezup_unregister_default_widgets(){
    unregister_widget( 'WP_Widget_Pages' );
    unregister_widget( 'WP_Widget_Calendar' );
    unregister_widget( 'WP_Widget_Archives' );
    unregister_widget( 'WP_Widget_Links' );
    unregister_widget( 'WP_Widget_Meta' );
    unregister_widget( 'WP_Widget_Search' );
    unregister_widget( 'WP_Widget_Text' );
    unregister_widget( 'WP_Widget_Categories' );
    unregister_widget( 'WP_Widget_Recent_Posts' );
    unregister_widget( 'WP_Widget_Recent_Comments' );
    unregister_widget( 'WP_Widget_RSS' );
    unregister_widget( 'WP_Widget_Tag_Cloud' );
    unregister_widget( 'WP_Nav_Menu_Widget' );
}
add_action( 'widgets_init', 'beezup_unregister_default_widgets' );


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


/*-----------------------------------------------------------------------------------*/
/* Enqueue Styles and Scripts
/*-----------------------------------------------------------------------------------*/
// Add defer attr to scripts
function beezup_defer_attr($tag, $handle){
    $scriptsToDefer = array('beezup-scripts', 'sendinblue-scripts', 'appointlet-scripts');
   
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
    wp_register_script( 'sendinblue-scripts', 'https://my.sendinblue.com/public/theme/version4/assets/js/src/subscribe-validate.js', array(), 1489660964, true );
    wp_register_script( 'appointlet-scripts', 'https://d35xd5ovpwtfyi.cloudfront.net/loader/loader.min.js', array(), null, true );
    
    wp_enqueue_script( 'beezup-scripts');
    wp_enqueue_script( 'sendinblue-scripts');
    wp_enqueue_script( 'appointlet-scripts');
    
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
