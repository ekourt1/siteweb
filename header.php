<?php
    defined( 'ABSPATH' ) or die();

    $slide_sidebar_classes = 'slide-sidebar-wrapper slide-sidebar-position-left';

    $header_classes = 'header';
    if ( !empty(technum_get_prefered_option('header_style')) ) {
        $header_classes .= ' header-' . esc_attr(technum_get_prefered_option('header_style'));
    }
    if ( !empty(technum_get_prefered_option('header_position')) ) {
        $header_classes .= ' header-position-' . esc_attr(technum_get_prefered_option('header_position'));
    }
    if ( !empty(technum_get_prefered_option('sticky_header_status')) ) {
        $header_classes .= ' sticky-header-' . esc_attr(technum_get_prefered_option('sticky_header_status'));
    }

    $mobile_classes = 'mobile-header';
    if ( !empty(technum_get_prefered_option('header_position')) ) {
        $mobile_classes .= ' mobile-header-position-' . esc_attr(technum_get_prefered_option('header_position'));
    }
    if ( !empty(technum_get_prefered_option('sticky_header_status')) ) {
        $mobile_classes .= ' sticky-header-' . esc_attr(technum_get_prefered_option('sticky_header_status'));
    }
    if ( !empty(technum_get_prefered_option('header_style')) ) {
        $mobile_classes .= ' mobile-header-' . esc_attr(technum_get_prefered_option('header_style'));
    }
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <?php wp_head(); ?>
    </head>

    <!-- Body -->
    <body <?php body_class(); ?>>
        <?php if ( function_exists( 'wp_body_open' ) ) {
                wp_body_open();
        } ?>
        <div class="body-overlay"></div>

        <?php if ( technum_get_prefered_option('page_loader_status') == 'on' ) { ?>
            <!-- Page Pre Loader -->
            <div class="page-loader-container">
                <div class="page-loader">
                    <div class="page-loader-inner">
                        <?php
                            if ( !empty(technum_get_prefered_option('page_loader_image')) ) {
                                $loader_image_metadata = wp_get_attachment_metadata(attachment_url_to_postid(technum_get_prefered_option('page_loader_image')));
                                $loader_image_width = (isset($loader_image_metadata['width']) ? $loader_image_metadata['width'] : 0);
                                $loader_image_height = (isset($loader_image_metadata['height']) ? $loader_image_metadata['height'] : 0);
                                $loader_image_url = technum_get_theme_mod('page_loader_image');

                                echo '<img width="' . esc_attr($loader_image_width) . '" height="' . esc_attr($loader_image_height) . '" src="' . esc_url($loader_image_url) . '" alt="' . esc_attr__('Page Loader Image', 'technum') . '"  class="page-loader-logo" />';
                            } else {
                                echo '<svg viewBox="0 0 286 290" class="page-loader-logo"><path d="m 260.16406,-0.56445312 c -2.38699,4.37671202 -7.40216,4.85973782 -11.5332,7.47656252 -3.67007,1.9190241 -7.92514,4.2106776 -11.89063,1.7871094 -5.51103,-4.6323487 -11.12758,2.2149542 -17.21679,3.8945312 -8.15356,4.830548 -16.88125,-4.1420314 -23.2793,4.416016 -5.5595,5.00947 -12.91928,6.637605 -16.58984,13.224609 -6.62522,3.064714 -16.14124,8.012786 -21.60352,15.888672 -5.1912,2.233601 -7.5053,5.947843 -13.03906,3.828125 -5.08849,6.703711 -6.65769,16.638537 -8.28711,26.25 -1.68296,3.793512 -6.73322,5.690418 -7.45703,13.40625 -0.13711,7.354404 -0.85275,14.858078 2.03711,22.007808 2.28648,10.73225 1.91161,21.83052 1.30859,32.58204 -1.58573,6.037 -1.69017,12.86743 -5.21289,17.74023 -2.40614,6.03817 -7.01959,9.73793 -8.69336,16.04688 -1.77871,7.70337 -6.97512,8.23352 -10.43945,13.58593 -5.96707,1.99909 1.41149,-7.47189 2.21094,-10.05273 0.93424,-4.82321 4.66453,-7.80199 4.24023,-13.53125 1.6596,-6.98598 3.85139,-13.84208 2.91016,-21.48242 0.10616,-5.48302 0.15944,-10.24531 -0.93946,-14.89649 0.96088,-8.08118 -0.74615,-17.21381 -0.24023,-25.81836 -1.29839,-5.58805 -1.15559,-7.835957 -0.89063,-12.828122 -2.55026,-12.35919 -1.63722,-25.362935 -4.21484,-37.88086 -0.15692,-5.890425 -0.35565,-14.228115 2.08984,-17.794922 4.10421,-12.231364 -9.2453,0.878036 -11.93945,4.453125 -2.511104,4.24334 -5.660901,8.17145 -7.888671,13.044922 -3.910676,4.665872 -9.184603,2.027407 -12.882813,7.714844 -3.90294,6.005641 -6.375975,11.846317 -10.164062,18.583984 -0.504924,5.103767 -3.763675,6.640265 -7.820313,2.498047 -4.652535,2.70154 -1.801294,11.330225 -5.607422,15.722656 -0.964802,8.079316 -2.792244,16.232666 -1.621093,24.363286 -6.274145,0.39383 -1.849239,10.98145 -1.625,14.96679 -4.520361,-0.0912 -4.159567,8.49827 -2.457032,14.34571 2.665969,6.74 5.873961,13.83809 8.867188,19.63671 -3.00723,2.18999 -1.611806,12.33909 1.857422,15.02344 3.108983,3.61283 7.956616,4.82613 9.886718,9.48828 2.41425,3.1214 3.943918,6.57987 4.220704,10.55274 -1.703369,4.18858 -1.414188,8.89065 -4.650391,12.69336 -3.002294,4.86624 -6.51284,7.47109 -10.636719,11.38476 -3.828721,2.08932 -6.047868,6.96613 -10.554687,7.66016 -4.637958,2.02969 -9.907594,4.87727 -13.96875,8.62695 -5.232166,4.86896 -9.619914,10.74828 -15.65625,14.48633 -4.7264,4.13154 -10.787449,7.65999 -14.4394534,13.08984 -2.6835218,0.55873 -3.9789269,5.47202 -6.82031248,5.84961 6.72289208,3.30474 -2.50337992,3.81508 0.95507813,8.54883 4.59306325,1.5358 5.64190795,-4.00482 8.78710935,-5.22851 3.5819564,-3.70344 6.5699764,-7.40526 10.8437504,-10.17188 2.253675,-3.2054 5.889712,-5.07023 9.398437,-7.23242 3.489853,-3.37013 7.615262,-2.99679 11.640625,-5.89063 7.419391,-3.51371 16.218864,-4.15518 24.384766,-6.27929 6.546334,-1.89697 12.898513,0.71737 19.257812,0.1875 5.414034,-2.28652 9.892779,-9.83121 2.742188,-13.59375 -3.886223,-4.03215 -14.406048,-5.54875 -15.316407,-7.58203 6.480796,-6.32053 14.846102,-10.6016 24.09961,-9.39844 3.899438,6.03772 17.229658,0.37222 20.798828,9.55664 3.60146,5.43152 8.9424,9.28194 14.3457,11.80664 4.67092,3.17851 7.965,5.89818 12.31055,9.25586 4.79563,2.03103 9.4576,3.3245 13.58008,6.57031 8.21276,2.86462 17.99005,3.30124 26.33594,0.18555 10.95892,-1.07269 22.9299,-2.95894 33.31445,-4.91992 4.53539,0.46113 3.18911,-3.97918 6.08008,-5.53907 9.09661,-1.46192 17.07822,-5.80386 25.29492,-8.95312 4.09825,-5.40181 12.88217,-8.69817 10.48242,-17.16016 6.44967,-2.96012 13.03384,-5.62891 19.62695,-8.17187 7.00836,-4.76164 11.14382,-12.17803 0.36524,-14.73438 -4.54299,-2.03717 -8.32841,-5.35873 -13.69727,-7.76172 -5.76999,-4.29283 -8.02674,-9.01034 -13.29101,-13.42773 -5.0018,-1.45859 -10.71521,-3.26195 -15.03711,-3.80273 -8.57854,-0.0175 1.08869,-5.6707 -5.67188,-7.8086 -2.31242,-4.70498 -9.19996,-3.17703 -13.70312,-3.60547 -6.20477,0.13458 -9.03431,-4.40977 -10.82813,-7.14648 -4.48705,-2.06138 -9.68762,-3.09466 -14.63476,-1.7168 -2.09078,-0.2472 -16.04716,1.14087 -10.47461,-0.99805 4.30288,-1.90221 11.92479,-0.33544 13.80664,-4.79687 9.29038,-1.87534 17.44535,-9.09404 26.07031,-13.53516 9.63238,-3.49866 8.61106,-13.72829 15.51953,-19.35351 5.64982,-2.56798 8.92938,-6.86598 12.1211,-11.41016 -0.51815,-5.25257 3.90075,-7.814469 4.1875,-13.162108 -0.12799,-7.116207 4.20677,-14.96681 7.4082,-19.650391 -1.8577,-5.736859 2.46308,-10.767188 0.043,-17.058593 0.43312,-4.970425 -4.65992,-10.076248 0.90039,-14.421876 -1.17308,-5.247987 -2.3589,-13.494819 -1.0957,-20.072265 -0.0933,-4.730402 0.12843,-8.937859 0.11523,-14.0468751 -1.10706,-3.0515253 3.31387,-7.6181582 -0.43555,-9.51562502 z" /></svg>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if ( technum_get_prefered_option('header_search_status') == 'on' ) { ?>
            <!-- Search Panel -->
            <div class="site-search">
                <div class="site-search-close"></div>
                <?php
                    $search_args = array(
                        'echo'          => true,
                        'aria_label'    => 'global'
                    );
                    get_search_form($search_args);
                ?>
            </div>
        <?php } ?>

        <!-- Mobile Menu Panel -->
        <?php
            get_template_part( 'templates/header/header-mobile-aside' );
        ?>

        <!-- Top Bar -->
        <?php
            if ( technum_get_prefered_option('top_bar_status') == 'on' ) {
                get_template_part( 'templates/top-bar/top-bar' );
            }
        ?>

        <div class="body-container">

            <?php
            if ( technum_get_prefered_option('side_panel_status') == 'on' && is_active_sidebar('sidebar-side') ) { ?>
                <!-- Side Panel -->
                <div class="<?php echo esc_attr($slide_sidebar_classes); ?>">
                    <div class="slide-sidebar">
                        <div class="slide-sidebar-close"></div>
                        <div class="slide-sidebar-content">
                            <?php dynamic_sidebar('sidebar-side'); ?>
                        </div>
                    </div>
                </div>
            <?php
            } ?>

            <!-- Mobile Header -->
            <?php
            echo '<div class="' . esc_attr($mobile_classes) . '">';
                echo (technum_get_prefered_option('sticky_header_status') == 'on' ? '<div class="sticky-wrapper">' : '');
                    get_template_part( 'templates/header/header-mobile' );
                echo (technum_get_prefered_option('sticky_header_status') == 'on' ? '</div>' : '');
            echo '</div>';
            ?>

            <?php
            if ( technum_get_prefered_option('header_status') == 'on' ) { ?>
                <!-- Header -->
                <?php
                echo '<header class="' . esc_attr($header_classes) . '">';
                    echo(technum_get_prefered_option('sticky_header_status') == 'on' ? '<div class="sticky-wrapper">' : '');
                        switch (technum_get_prefered_option('header_style')) {
                            case 'type-2' :
                                get_template_part('templates/header/header-2');
                                break;
                            case 'type-3' :
                                get_template_part('templates/header/header-3');
                                break;
                            default :
                                get_template_part('templates/header/header-1');
                                break;
                        }
                    echo(technum_get_prefered_option('sticky_header_status') == 'on' ? '</div>' : '');
                echo '</header>';
            }
            ?>

            <?php
            // Page Title
            if (technum_get_prefered_option('page_title_status') == 'on') {
                get_template_part( 'templates/page-title/page-title' );
            }
            ?>