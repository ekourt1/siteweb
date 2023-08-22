<div <?php post_class('service-item-wrapper'); ?>>
    <div class="service-item">

        <?php
            if (!empty(get_the_title())) {
                echo '<h5 class="service-post-title"><a href="' . esc_url(get_the_permalink()) . '">' . get_the_title() . '</a></h5>';
            }
        ?>

        <?php
            if ( !empty(technum_get_post_option('service_description')) ) {
                echo '<div class="service-item-excerpt">';
                    $excerpt_length = (!empty($args['excerpt_length']) ? $args['excerpt_length'] : technum_get_theme_mod('service_archive_excerpt_length'));
                    if ( has_excerpt() ) {
                        echo substr(get_the_excerpt(), 0, $excerpt_length);
                    } else {
                        $content = technum_get_post_option('service_description');
                        $content = strip_shortcodes($content);
                        $content = wp_strip_all_tags($content);
                        $content = apply_filters( 'the_content', $content );
                        $content = preg_replace( '/\[.*?(\"title\":\"(.*?)\").*?\]/', '$2', $content );
                        $content = preg_replace( '/\[.*?(|title=\"(.*?)\".*?)\]/', '$2', $content );
                        $content = preg_replace( '|\s+|', ' ', $content );
                        echo substr(strip_tags($content), 0, $excerpt_length);
                    }
                echo '</div>';
            }
        ?>

        <?php
            if ( !empty(technum_get_post_option('service_main_icon')) ) {
                echo '<div class="service-item-icon">';
                    echo '<div class="service-icon">';
                        echo '<i class="' . esc_attr(technum_get_post_option('service_main_icon')) . '"' . (!empty(technum_get_post_option('service_main_icon_color')) ? ' style="color: ' . esc_attr(technum_get_post_option('service_main_icon_color')) . '"' : '') . '></i>';
                        echo '<div class="service-icon-bg"' . (!empty(technum_get_post_option('service_main_icon_color')) ? ' style="background-color: ' . esc_attr(technum_get_post_option
                                ('service_main_icon_color')) . '"' : '') . '></div>';
                    echo '</div>';
                echo '</div>';
            }
        ?>

    </div>
</div>