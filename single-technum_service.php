<?php
/**
 * The template for displaying single project item page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage TechnUm
 * @since TechnUm 1.0
 */

the_post();
get_header();

$sidebar_args = technum_get_sidebar_args();
$sidebar_position = $sidebar_args['sidebar_position'];

$content_classes = 'content-wrapper';
$content_classes .= ' content-wrapper-sidebar-position-' . esc_attr($sidebar_position);
$content_classes .= ( technum_get_post_option('content_top_margin') == 'on' ? ' content-wrapper-remove-top-margin' : '' );

$additional_classes = 'content-wrapper content-wrapper-sidebar-position-none';
if ( empty(get_the_content()) ) {
    $content_classes .= ( technum_get_post_option('content_bottom_margin') == 'on' ? ' content-wrapper-remove-bottom-margin' : '' );
} else {
    $additional_classes .= ( technum_get_post_option('content_bottom_margin') == 'on' ? ' content-wrapper-remove-bottom-margin' : '' );
};
?>

    <div class="<?php echo esc_attr($content_classes); ?>">

        <!-- Content Container -->
        <div class="content">

            <div id="service-<?php the_ID(); ?>" class="single-service">

                <div class="service-post-content">

                    <?php
                        if ( !empty(technum_post_media_output()) ) {
                            echo '<div class="post-media-wrapper">';
                                echo technum_post_media_output();
                            echo '</div>';
                        }

                        if ( !empty(get_the_title()) ) {
                            echo '<h2 class="post-title">' . get_the_title() . '</h2>';
                        }

                        if ( !empty(technum_get_post_option('service_description')) ) {
                            echo do_shortcode( wpautop( rwmb_meta('service_description') ) );;
                        }

                        // Benefits
                        if ( !empty(technum_get_post_option('service_benefit_items')) ) {
                            if ( !empty(technum_get_post_option('service_benefits_title')) ) {
                                echo '<h4>' . esc_attr(technum_get_post_option('service_benefits_title')) . '</h4>';
                            }
                            echo '<div class="benefits-wrapper">';
                                $benefits = technum_get_post_option('service_benefit_items');
                                foreach ($benefits as $benefit) {
                                    echo '<div class="benefit-item-wrapper">';
                                        echo '<div class="benefit-item">';
                                            if ( !empty($benefit[0]) ) {
                                                echo '<div class="benefit-item-icon">';
                                                    echo '<i class="' . esc_attr($benefit[0]) . '"' . (!empty($benefit[2]) ? ' style="color: ' . esc_attr($benefit[2]) . '"' : '') . '></i>';
                                                    echo '<div class="benefit-item-icon-bg"' . (!empty($benefit[2]) ? ' style="background-color: ' . esc_attr($benefit[2]) . '"' : '') . '></div>';
                                                echo '</div>';
                                            }
                                            if ( !empty($benefit[1]) ) {
                                                echo '<div class="benefit-item-title">';
                                                    echo '<h6>' . esc_html($benefit[1]) . '</h6>';
                                                echo '</div>';
                                            }
                                        echo '</div>';
                                    echo '</div>';
                                }
                            echo '</div>';
                        }

                        // FAQ
                        if (!empty(technum_get_post_option('service_help_items'))) {
                            if ( !empty(technum_get_post_option('service_help_title')) ) {
                                echo '<h4>' . esc_html(technum_get_post_option('service_help_title')) . '</h4>';
                            }
                            echo '<div class="help-wrapper">';
                                $helps = technum_get_post_option('service_help_items');
                                foreach ($helps as $help) {
                                    echo '<div class="help-item">';
                                        if ( !empty($help[0]) ) {
                                            echo '<div class="help-item-title">';
                                                echo esc_html($help[0]);
                                            echo '</div>';
                                        }
                                    if ( !empty($help[1]) ) {
                                        echo '<div class="help-item-content">';
                                            echo esc_html($help[1]);
                                        echo '</div>';
                                    }
                                    echo '</div>';
                                }
                            echo '</div>';
                        }

                    ?>

                </div>
            </div>

        </div>

        <!-- Sidebar Container -->
        <?php get_sidebar(); ?>

    </div>

    <?php
        if ( !empty(get_the_content()) ) {
            echo '<div class="' . esc_attr($additional_classes) . '">';
                echo '<div class="content">';
        }
        the_content();
        if ( !empty(get_the_content()) ) {
                echo '</div>';
            echo '</div>';
        }
    ?>

<?php
get_footer();