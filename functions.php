<?php
/*
 * Created by Artureanec
*/

# General
add_theme_support('title-tag');
add_theme_support('automatic-feed-links');
add_theme_support('post-formats', array('image', 'video', 'gallery', 'quote'));
add_theme_support('html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

if( !isset( $content_width ) ) $content_width = 1170;

# ADD Localization Folder
add_action('after_setup_theme', 'technum_pomo');
if (!function_exists('technum_pomo')) {
    function technum_pomo() {
        load_theme_textdomain('technum', get_template_directory() . '/languages');
    }
}

require_once(get_template_directory() . '/core/helper-functions.php');
require_once(get_template_directory() . '/core/layout-functions.php');
require_once(get_template_directory() . '/core/init.php');

# Register CSS/JS
add_action('wp_enqueue_scripts', 'technum_css_js');
if (!function_exists('technum_css_js')) {
    function technum_css_js() {
        # CSS
        wp_enqueue_style('technum-theme', get_template_directory_uri() . '/css/theme.css');

        if (class_exists('WooCommerce')) {
            wp_enqueue_style('technum-woocommerce', get_template_directory_uri() . '/css/woocommerce.css');
            wp_enqueue_style('technum-style', get_template_directory_uri() . '/style.css', array('technum-theme', 'technum-woocommerce'), wp_get_theme()->get('Version') );
        } else {
            wp_enqueue_style('technum-style', get_template_directory_uri() . '/style.css', array('technum-theme'), wp_get_theme()->get('Version') );
        }

        # JS
        wp_enqueue_script('jquery-cookie', get_template_directory_uri() . '/js/jquery.cookie.min.js', array('jquery'), false, true);
        wp_enqueue_script('tilt', get_template_directory_uri() . '/js/tilt.jquery.min.js', array('jquery'), false, true);
        wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', true, false, true);
        wp_enqueue_script('isotope', get_template_directory_uri() . '/js/isotope.min.js', array(), false, true );

        wp_register_script('technum-theme', get_template_directory_uri() . '/js/theme.js', array('jquery', 'isotope', 'tilt'), false, true);
        wp_localize_script( 'technum-theme', 'ajax_params', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
        wp_enqueue_script('technum-theme');


        if (is_singular() && comments_open()) {
            wp_enqueue_script('comment-reply');
        }

        wp_localize_script('technum-theme', 'technum_ajaxurl',
            array(
                'url' => esc_url(admin_url('admin-ajax.php'))
            )
        );

        # Colors & Settings
        require_once(get_template_directory() . "/css/custom/custom.php");

        global $technum_custom_css;
        wp_add_inline_style('technum-theme', $technum_custom_css);
    }
}

# Register CSS/JS for Admin Settings
add_action('admin_enqueue_scripts', 'technum_admin_css_js');
if (!function_exists('technum_admin_css_js')) {
    function technum_admin_css_js() {
        # CSS
        wp_enqueue_style('technum-admin', get_template_directory_uri() . '/css/admin.css');
        # JS
        wp_enqueue_script('technum-admin', get_template_directory_uri() . '/js/admin.js', array('jquery', 'jquery-ui-core', 'jquery-ui-sortable'), false, true);
    }
}

# Register CSS for Gutenberg Editor
    add_action('enqueue_block_editor_assets', 'technum_gutenberg_css', 1, 1);
    add_action('enqueue_block_editor_assets', 'technum_register_theme_fonts', 1, 1);
    if (!function_exists('technum_gutenberg_css')) {
        function technum_gutenberg_css() {
            add_theme_support( 'editor-styles' );
            add_editor_style( 'css/gutenberg-editor.css' );

            require_once(get_template_directory() . "/css/custom/custom.php");
            global $technum_custom_css;
            wp_enqueue_style('technum-admin', get_template_directory_uri() . '/css/admin.css');
            wp_add_inline_style('technum-admin', $technum_custom_css);
        }
    }

# Register Google Fonts
add_action('wp_enqueue_scripts', 'technum_register_theme_fonts');
if (!function_exists('technum_register_theme_fonts')) {
    function technum_register_theme_fonts() {
        $font_control_list      = !empty(get_theme_mod('current_fonts')) ? get_theme_mod('current_fonts') : array();
        $current_fonts_array    = array();
        $families               = array();
        $result                 = array();
        foreach ( $font_control_list as $control ) {
            $values = technum_get_theme_mod($control);
            $values = json_decode($values, true);
            if ( isset($values['font_family']) && !empty($values['font_family']) ) {
                $current_font = array();
                $current_font['font_family'] = $values['font_family'];
                $current_font['font_styles'] = $values['font_styles'];
                $current_font['font_subset'] = $values['font_subset'];
                $current_fonts_array[$control] = $current_font;
            }
        }

        if ( !empty($current_fonts_array) && is_array($current_fonts_array) ) {
            foreach ( $current_fonts_array as $item ) {
                if ( !in_array($item['font_family'], $families) ) {
                    $families[] = $item['font_family'];
                }
            }
            foreach ( $families as $variant ) {
                foreach ( $current_fonts_array as $key => $item ) {
                    if ( $variant == $item['font_family'] ) {
                        $result[$variant]['font_styles'] = empty($result[$variant]['font_styles']) ? $item['font_styles'] : $result[$variant]['font_styles'] . ',' . $item['font_styles'];
                        $result[$variant]['font_subset'] = empty($result[$variant]['font_subset']) ? $item['font_subset'] : $result[$variant]['font_subset'] . ',' . $item['font_subset'];
                    }
                }
            }
            foreach ( $result as $key => $value ) {
                $styles = array_unique(explode(',', $result[$key]['font_styles']));
                asort($styles, SORT_NUMERIC );
                $subset = array_unique(explode(',', $result[$key]['font_subset']));
                asort($subset, SORT_NUMERIC );
                $result[$key]['font_styles'] = implode( ',', $styles );
                $result[$key]['font_subset'] = implode( ',', $subset );
            }
            if ( !empty($result) && is_array($result) ) {
                $fonts = array();
                foreach ( $result as $font_name => $font_params ) {
                    // exclude local fonts
                    $fonts[] = $font_name . ':' . $font_params['font_styles'] . '&subset=' . $font_params['font_subset'];
                }
                $fonts_url = '//fonts.googleapis.com/css?family=' . urlencode( implode('|', $fonts) );
                wp_enqueue_style('technum-fonts', $fonts_url);
            }
        }
    }
}



# WP Footer
add_action('wp_footer', 'technum_wp_footer');
if (!function_exists('technum_wp_footer')) {
    function technum_wp_footer() {
        TechnUm_Helper::getInstance()->echoFooter();
    }
}

# Register Menu
add_action('init', 'technum_register_menu');
if (!function_exists('technum_register_menu')) {
    function technum_register_menu() {
        register_nav_menus(
            [
                'main'              => esc_html__('Main menu', 'technum'),
                'top_bar_user_menu' => esc_html__('Top bar menu', 'technum'),
                'footer_menu'       => esc_html__('Footer Menu', 'technum'),
                'footer_add_menu'   => esc_html__('Footer Additional Menu', 'technum')
            ]
        );
    }
}


# Register Sidebars
add_action('widgets_init', 'technum_widgets_init');
if (!function_exists('technum_widgets_init')) {
    function technum_widgets_init() {
        register_sidebar(
            array(
                'name'          => esc_html__('Page Sidebar', 'technum'),
                'id'            => 'sidebar',
                'description'   => esc_html__('Widgets in this area will be shown on all pages.', 'technum'),
                'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h4 class="widget-title"><span>',
                'after_title'   => '</span></h4>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Post Sidebar', 'technum'),
                'id'            => 'sidebar-post',
                'description'   => esc_html__('Widgets in this area will be shown on all posts.', 'technum'),
                'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h4 class="widget-title"><span>',
                'after_title'   => '</span></h4>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Vacancy Sidebar', 'technum'),
                'id'            => 'sidebar-vacancy',
                'description'   => esc_html__('Widgets in this area will be shown on all vacancy pages.', 'technum'),
                'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h4 class="widget-title"><span>',
                'after_title'   => '</span></h4>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Service Sidebar', 'technum'),
                'id'            => 'sidebar-service',
                'description'   => esc_html__('Widgets in this area will be shown on all service pages.', 'technum'),
                'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h4 class="widget-title"><span>',
                'after_title'   => '</span></h4>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Archive Sidebar', 'technum'),
                'id'            => 'sidebar-archive',
                'description'   => esc_html__('Widgets in this area will be shown on all posts and archive pages.', 'technum'),
                'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h4 class="widget-title"><span>',
                'after_title'   => '</span></h4>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Side Panel Sidebar', 'technum'),
                'id'            => 'sidebar-side',
                'description'   => esc_html__('Widgets in this area will be shown on side panel.', 'technum'),
                'before_widget' => '<div id="%1$s" class="widget side-widget %2$s"><div class="widget-wrapper side-widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h4 class="widget-title side-widget-title">',
                'after_title'   => '</h4>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Footer Sidebar (Style 1)', 'technum'),
                'id'            => 'sidebar-footer-style1',
                'description'   => esc_html__('Widgets in this area will be shown on footer area.', 'technum'),
                'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s"><div class="widget-wrapper footer-widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h6 class="widget-title footer-widget-title">',
                'after_title'   => '</h6>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Footer Sidebar (Style 2)', 'technum'),
                'id'            => 'sidebar-footer-style2',
                'description'   => esc_html__('Widgets in this area will be shown on footer area.', 'technum'),
                'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s"><div class="widget-wrapper footer-widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h6 class="widget-title footer-widget-title">',
                'after_title'   => '</h6>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Footer Sidebar (Style 3)', 'technum'),
                'id'            => 'sidebar-footer-style3',
                'description'   => esc_html__('Widgets in this area will be shown on footer area.', 'technum'),
                'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s"><div class="widget-wrapper footer-widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h6 class="widget-title footer-widget-title">',
                'after_title'   => '</h6>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Footer Sidebar (Style 4)', 'technum'),
                'id'            => 'sidebar-footer-style4',
                'description'   => esc_html__('Widgets in this area will be shown on footer area.', 'technum'),
                'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s"><div class="widget-wrapper footer-widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h6 class="widget-title footer-widget-title">',
                'after_title'   => '</h6>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__('Footer Sidebar (Style 5)', 'technum'),
                'id'            => 'sidebar-footer-style5',
                'description'   => esc_html__('Widgets in this area will be shown on footer area.', 'technum'),
                'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s"><div class="widget-wrapper footer-widget-wrapper">',
                'after_widget'  => '</div></div>',
                'before_title'  => '<h6 class="widget-title footer-widget-title">',
                'after_title'   => '</h6>',
            )
        );

        if (class_exists('WooCommerce')) {
            register_sidebar(
                array(
                    'name'          => esc_html__('Sidebar WooCommerce', 'technum'),
                    'id'            => 'sidebar-woocommerce',
                    'description'   => esc_html__('Widgets in this area will be shown on Woocommerce Pages.', 'technum'),
                    'before_widget' => '<div id="%1$s" class="widget wooсommerce-widget %2$s"><div class="widget-wrapper">',
                    'after_widget'  => '</div></div>',
                    'before_title'  => '<h4 class="widget-title"><span>',
                    'after_title'   => '</span></h4>',
                )
            );
        }
    }
}

// Init Custom Widgets
if ( function_exists('technum_add_custom_widget') ) {
    technum_add_custom_widget('Technum_Contacts_Widget');
    technum_add_custom_widget('Technum_Featured_Posts_Widget');
    technum_add_custom_widget('Technum_Banner_Widget');
    technum_add_custom_widget('Technum_Nav_Menu_Widget');
}

// Init Elementor for Custom Post Types
if (!function_exists('technum_init_elementor_for_team_post_type')) {
    function technum_init_elementor_for_team_post_type() {
        add_post_type_support('technum-team', 'elementor');
    }
}
add_action('init', 'technum_init_elementor_for_team_post_type');

if (!function_exists('technum_init_elementor_for_portfolio_post_type')) {
    function technum_init_elementor_for_portfolio_post_type() {
        add_post_type_support('technum-portfolio', 'elementor');
    }
}
add_action('init', 'technum_init_elementor_for_portfolio_post_type');

# WooCommerce
if (class_exists('WooCommerce')) {
    require_once( get_template_directory() . '/woocommerce/wooinit.php');
}

// Remove standard WP gallery styles
add_filter( 'use_default_gallery_style', '__return_false' );

// Register custom image sizes
if ( function_exists( 'add_theme_support' ) ) {
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 1170, 471, true );
}
if ( function_exists( 'add_image_size' ) ) {
    add_image_size( 'technum_post_thumbnail_mobile', 535, 300, array('center', 'center') );
    add_image_size( 'technum_post_thumbnail_tablet', 951, 438, array('center', 'center') );
    add_image_size( 'technum_post_thumbnail_default', 870, 350, array('center', 'center') );
    add_image_size( 'technum_post_thumbnail_full', 1170, 471, array('center', 'center') );

    add_image_size( 'technum_post_grid_2_columns', 920, 780, array('center', 'center') );
    add_image_size( 'technum_post_grid_3_columns', 600, 450, array('center', 'center') );
    add_image_size( 'technum_post_grid_4_columns', 440, 374, array('center', 'center') );
    add_image_size( 'technum_post_grid_5_columns', 344, 292, array('center', 'center') );
    add_image_size( 'technum_post_grid_6_columns', 280, 238, array('center', 'center') );

    add_image_size( 'technum_portfolio_thumbnail', 835, 518, array('center', 'center') );
    add_image_size( 'technum_portfolio_grid_1_columns', 1200, 1200, array('center', 'center') );
    add_image_size( 'technum_portfolio_grid_2_columns', 960, 960, array('center', 'center') );
    add_image_size( 'technum_portfolio_grid_3_columns', 640, 640, array('center', 'center') );
    add_image_size( 'technum_portfolio_grid_4_columns', 480, 480, array('center', 'center') );
    add_image_size( 'technum_portfolio_grid_5_columns', 384, 384, array('center', 'center') );
    add_image_size( 'technum_portfolio_grid_6_columns', 320, 320, array('center', 'center') );

    add_image_size( 'technum_portfolio_masonry_1_columns', 1920, 1440, array('center', 'center') );
    add_image_size( 'technum_portfolio_masonry_2_columns', 1920, 1440, array('center', 'center') );
    add_image_size( 'technum_portfolio_masonry_3_columns', 1280, 960, array('center', 'center') );
    add_image_size( 'technum_portfolio_masonry_4_columns', 960, 720, array('center', 'center') );
    add_image_size( 'technum_portfolio_masonry_5_columns', 768, 576, array('center', 'center') );
    add_image_size( 'technum_portfolio_masonry_6_columns', 640, 480, array('center', 'center') );

    add_image_size( 'technum_portfolio_metro_1_columns', 1920, 1920, array('center', 'center') );
    add_image_size( 'technum_portfolio_metro_2_columns', 1920, 1920, array('center', 'center') );
    add_image_size( 'technum_portfolio_metro_3_columns', 1280, 1280, array('center', 'center') );
    add_image_size( 'technum_portfolio_metro_4_columns', 960, 960, array('center', 'center') );
    add_image_size( 'technum_portfolio_metro_5_columns', 768, 768, array('center', 'center') );
    add_image_size( 'technum_portfolio_metro_6_columns', 640, 640, array('center', 'center') );

    add_image_size( 'technum_team_thumbnail', 572, 456, array('center', 'center') );
}
add_filter( 'image_size_names_choose', 'technum_image_size_names' );
if ( !function_exists( 'technum_image_size_names' ) ) {
    function technum_image_size_names($sizes) {
        return array_merge($sizes, array(
            'technum_post_thumbnail_default'    => esc_html__('Post Thumbnail (Default)', 'technum'),
            'technum_post_thumbnail_full'       => esc_html__('Post Thumbnail (Full)', 'technum'),
        ));
    }
}

// Media Upload
if (!function_exists('technum_enqueue_media')) {
    function technum_enqueue_media() {
        wp_enqueue_media();
    }
}
add_action( 'admin_enqueue_scripts', 'technum_enqueue_media' );

// Responsive video
add_filter('embed_oembed_html', 'technum_wrap_oembed_video', 99, 4);
if (!function_exists('technum_wrap_oembed_video')) {
    function technum_wrap_oembed_video($html, $url, $attr, $post_id) {
        return '<div class="video-embed">' . $html . '</div>';
    }
}

// Custom Search form
add_filter('get_search_form', 'technum_get_search_form', 10, 2);
if ( !function_exists('technum_get_search_form') ) {
    function technum_get_search_form($form, $args) {
        $search_rand = mt_rand(0, 999);
        $search_js = 'javascript:document.getElementById("search-' . esc_js($search_rand) . '").submit();';
        $placeholder = ( $args['aria_label'] == 'global' ? esc_attr__('Type Your Search...', 'technum') : esc_attr__('Search...', 'technum') );

        $form = '<form name="search_form" method="get" action="' . esc_url(home_url('/')) . '" class="search-form" id="search-' . esc_attr($search_rand) . '">';
            $form .= '<span class="search-form-icon" onclick="' . esc_js($search_js) . '"></span>';
            $form .= '<input type="text" name="s" value="" placeholder="' . esc_attr($placeholder) . '" title="' . esc_attr__('Search', 'technum') . '" class="search-form-field">';
        $form .= '</form>';

        return $form;
    }
}

// Customize WP Categories Widget
add_filter('wp_list_categories', 'technum_customize_categories_widget', 10, 2);
if ( !function_exists('technum_customize_categories_widget') ) {
    function technum_customize_categories_widget($output, $args) {
        $args['use_desc_for_title'] = false;
        $output = str_replace('"cat-item', '"cat-item cat-item-hierarchical', $output);

        return $output;
    }
}

// Add 'Background color' button to Tiny MCE text editor
add_action( 'init', 'technum_tiny_mce_background_color' );
if ( !function_exists('technum_tiny_mce_background_color') ) {
    function technum_tiny_mce_background_color() {
        add_filter('mce_buttons_2', 'technum_tiny_mce_background_color_button', 999, 1);
    }
}
if ( !function_exists('technum_tiny_mce_background_color_button') ) {
    function technum_tiny_mce_background_color_button($buttons) {
        array_splice($buttons, 4, 0, 'backcolor');
        return $buttons;
    }
}

// Move Comment Message field in Comment form
add_filter( 'comment_form_fields', 'cosmacos_move_comment_fields' );
if ( !function_exists('cosmacos_move_comment_fields') ) {
    function cosmacos_move_comment_fields($fields) {
        if ( !function_exists('is_product') || !is_product() ) {
            $comment_field = $fields['comment'];
            $cookies_field = $fields['cookies'];
            unset($fields['comment']);
            unset($fields['cookies']);
            $fields['comment'] = $comment_field;
            $fields['cookies'] = $cookies_field;
        }
        return $fields;
    }
}

// WPForms Plugin Dropdown Menu Fix
if ( function_exists( 'wpforms') ) {
    add_action( 'wpforms_display_field_select', 'technum_wpform_start_select_wrapper', 5, 1 );
    if ( !function_exists('technum_wpform_start_select_wrapper') ) {
        function technum_wpform_start_select_wrapper($field) {
            echo '<div class="select-wrap' . (!empty($field['size']) && isset($field['size']) ? ' wpforms-field-' . esc_attr($field['size']) : '') . '">';
        }
    }
    add_action( 'wpforms_display_field_select', 'technum_wpform_finish_select_wrapper', 15 );
    if ( !function_exists('technum_wpform_finish_select_wrapper') ) {
        function technum_wpform_finish_select_wrapper() {
            echo '</div>';
        }
    }
}

// Custom Password Form
add_filter( 'the_password_form', 'technum_password_form' );
if ( !function_exists('technum_password_form') ) {
    function technum_password_form() {
        global $post;
        $out = '<form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" class="post-password-form" method="post"><p>' . esc_html__('This content is password protected. To view it please enter your password below:', 'technum') . '</p><p><label for="password"><input name="post_password" id="password" type="password" placeholder="' . esc_attr__('Password', 'technum') . '" size="20" required /></label><button name="Submit">' . esc_html__('Enter', 'technum') . '</button></p></form>';
        return $out;
    }
}

// Set Elementor Features Default Values
add_action( 'elementor/experiments/feature-registered', 'technum_elementor_features_set_default', 10, 2 );
if ( !function_exists('technum_elementor_features_set_default') ) {
    function technum_elementor_features_set_default( Elementor\Core\Experiments\Manager $experiments_manager ) {
        $experiments_manager->set_feature_default_state('e_dom_optimization', 'inactive');
    }
}

// Set custom palette in customizer colorpicker
add_action( 'customize_controls_enqueue_scripts', 'technum_custom_color_palette' );
if ( !function_exists('technum_custom_color_palette') ) {
    function technum_custom_color_palette() {
        $color_palettes = json_encode(technum_get_custom_color_palette());
        wp_add_inline_script('wp-color-picker', 'jQuery.wp.wpColorPicker.prototype.options.palettes = ' . sprintf('%s', $color_palettes) . ';');
    }
}

// Filter for widgets
add_filter( 'dynamic_sidebar_params', 'technum_dynamic_sidebar_params' );
if (!function_exists('technum_dynamic_sidebar_params')) {
    function technum_dynamic_sidebar_params($sidebar_params) {
        if (is_admin()) {
            return $sidebar_params;
        }
        global $wp_registered_widgets;
        $widget_id = $sidebar_params[0]['widget_id'];
        $wp_registered_widgets[$widget_id]['original_callback'] = $wp_registered_widgets[$widget_id]['callback'];
        $wp_registered_widgets[$widget_id]['callback'] = 'technum_widget_callback_function';

        return $sidebar_params;
    }
}
add_filter( 'widget_output', 'technum_output_filter', 10, 3 );
if (!function_exists('technum_output_filter')) {
    function technum_output_filter($widget_output, $widget_id_base, $widget_id) {
        if ($widget_id_base != 'woocommerce_product_categories' && $widget_id_base != 'wpforms-widget' && $widget_id_base != 'block') {
            $widget_output = str_replace('<select', '<div class="select-wrap"><select', $widget_output);
            $widget_output = str_replace('</select>', '</select></div>', $widget_output);
        }

        return $widget_output;
    }
}

// Admin Footer
add_filter('admin_footer', 'technum_admin_footer');
if (!function_exists('technum_admin_footer')) {
    function technum_admin_footer() {
        if (strlen(get_page_template_slug())>0) {
            echo "<input type='hidden' name='' value='" . (get_page_template_slug() ? get_page_template_slug() : '') . "' class='technum_this_template_file'>";
        }
    }
}

// Remove post format parameter
add_filter('preview_post_link', 'technum_remove_post_format_parameter', 9999);
if (!function_exists('technum_remove_post_format_parameter')) {
    function technum_remove_post_format_parameter($url) {
        $url = remove_query_arg('post_format', $url);
        return $url;
    }
}

// Post excerpt customize
add_filter( 'excerpt_length', function() {
    return 41;
} );
add_filter( 'excerpt_more', function(){
    return '...';
} );

// Wrap pagination links
add_filter( 'paginate_links_output', 'technum_wrap_pagination_links', 10, 2 );
if ( !function_exists('technum_wrap_pagination_links') ) {
    function technum_wrap_pagination_links($template, $args) {
        return '<div class="content-pagination">' .
                    '<nav class="navigation pagination" role="navigation">' .
                        '<h2 class="screen-reader-text">' . esc_html__('Pagination', 'technum') . '</h2>' .
                        '<div class="nav-links">' .
                            wp_kses($template, array(
                                'span'  => array(
                                    'class'         => true,
                                    'aria-current'  => true
                                ),
                                'div'  => array(
                                    'class'         => true
                                ),
                                'a'     => array(
                                    'class'         => true,
                                    'href'          => true
                                )
                            )) .
                        '</div>' .
                    '</nav>' .
                '</div>';
    }
}

//Add Ajax Actions
add_action('wp_ajax_pagination', 'ajax_pagination');
add_action('wp_ajax_nopriv_pagination', 'ajax_pagination');

//Construct Loop & Results
function ajax_pagination() {
    $query_data         = $_POST;

    $paged              = ( isset($query_data['paged']) ) ? intval($query_data['paged']) : 1;
    $filter_term        = ( isset($query_data['filter_term']) ) ? $query_data['filter_term'] : null;
    $filter_taxonomy    = ( isset($query_data['filter_taxonomy']) ) ? $query_data['filter_taxonomy'] : null;
    $args               = ( isset($query_data['args']) ) ? json_decode(stripslashes($query_data['args']), true) : array();
    $args               = array_merge($args, array( 'paged' => sanitize_key($paged) ));
    if ( !empty($filter_term) && !empty($filter_taxonomy) ) {
        $args   = array_merge($args, array( sanitize_key($filter_taxonomy) => sanitize_key($filter_term) ));
    }
    $post_type          = isset($args['post_type']) ? $args['post_type'] : 'post';
    $widget             = ( isset($query_data['widget']) ) ? json_decode(stripslashes($query_data['widget']), true) : array();
    $query              = new WP_Query($args);

    $wrapper_class      = isset($query_data['classes']) ? $query_data['classes'] : '';
    $id                 = isset($query_data['id']) ? $query_data['id'] : '';
    $link_base          = isset($args['link_base']) ? $args['link_base'] : '';

    echo '<div class="' . esc_attr($wrapper_class) . '">';
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('content', $post_type, $widget);
        };
        wp_reset_postdata();
    echo '</div>';

    echo paginate_links( array(
        'base'      => $link_base . '/?' . esc_attr($id) . '-paged=%#%',
        'current'   => max( 1, $paged ),
        'total'     => $query->max_num_pages,
        'end_size'  => 2,
        'prev_text' => '<div class="button-icon"></div>',
        'next_text' => '<div class="button-icon"></div>',
        'add_args'  => false
    ) );

    die();
}

// Customize WP-Blocks Output
if ( !function_exists('technum_wpblock_dropdown_wrapper') ) {
    function technum_wpblock_dropdown_wrapper($block_content, $block) {

        if (
            isset($block['attrs']['displayAsDropdown']) && $block['attrs']['displayAsDropdown'] === true
        ) {
            $block_content = str_replace('<select', '<div class="select-wrap"><select', $block_content);
            $block_content = str_replace('</select>', '</select></div>', $block_content);
        }

        if (
            ( $block['blockName'] == 'core/search' && isset($block['attrs']['buttonUseIcon']) && $block['attrs']['buttonUseIcon'] === true ) ||
            ( $block['blockName'] == 'woocommerce/product-search' )
        ) {
            $block_content = preg_replace('/<svg\s+.*(<\/svg>)/s', '', $block_content);
        }

        if ( $block['blockName'] == 'core/loginout' && isset($block['attrs']['displayLoginAsForm']) && $block['attrs']['displayLoginAsForm'] === true ) {
            $block_content = str_replace('id="user_login"', 'id="user_login" placeholder="' . esc_html__('Username or Email Address', 'cosmecos') . '"', $block_content);
            $block_content = str_replace('id="user_pass"', 'id="user_pass" placeholder="' . esc_html__('Password', 'cosmecos') . '"', $block_content);
            $block_content = preg_replace('/<label for.*<\/label>/', '', $block_content);
        }

        return $block_content;
    }
}

add_filter( 'render_block', 'technum_wpblock_dropdown_wrapper', 10, 2 );